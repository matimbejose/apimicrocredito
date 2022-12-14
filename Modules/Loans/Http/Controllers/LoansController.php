<?php

namespace Modules\Loans\Http\Controllers;

use Modules\Loans\Utils\LoanUtil;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Loans\Entities\CreditType;
use Modules\Loans\Entities\Loan;
use Modules\Customers\Entities\Customer;
use Modules\Managers\Entities\Manager;
use Modules\Loans\Entities\Warranty;
use Modules\Loans\Utils\Util;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\Account;
use Modules\Base\Entities\User;
use Modules\Business\Entities\Business;
use Modules\Loans\Entities\LoanSchedule;
use Modules\Loans\Entities\LoanTransaction;
use Modules\Loans\Http\Requests\CreateLoanRequest;
use Modules\Loans\Http\Requests\LoanSimulate;
use Modules\Loans\Http\Requests\UpdateLoanRequest;

class LoansController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('view', Loan::class);

        $loans = Loan::join('customers', 'customers.id', 'loans.customer_id')
            ->join('users', 'users.id', 'loans.user_id')
            ->with('loan_transactions')
            ->select(
                'loans.*',
                'customers.name as customer',
                'users.name as manager',
            )
            ->get();

        return response()->json($loans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function simulate(LoanSimulate $request)
    {
        // dd($request->getHost());
        $this->authorize('view', Loan::class);
        $simulation = [];

        $credit_type = CreditType::find($request->credit_type);
        $anual_tax = $credit_type->tax;
        $anual_tax_decimal = $anual_tax / 100;
        $next_due = 1;
        $amount = floatval($request->amount);
        $final_balance = $amount;

        $i = 0;
        while ($final_balance > 0) {
            $fees = floatval($final_balance) * $anual_tax_decimal;
            $tmp['final_balance'] = floatval($final_balance);
            $tmp['effective_payment'] = floatval($amount) / floatval($request->maturity);
            $tmp['index'] = $i + 1 . 'ª Prestação';
            $tmp['scheduled_date'] = LoanUtil::getScheduledDate($credit_type->type, $next_due);
            $final_balance = $final_balance - $tmp['effective_payment'];
            $tmp['fees'] = $fees;
            $tmp['main_capital'] = $tmp['effective_payment'] + $fees;
            array_push($simulation, $tmp);
            $next_due += intval($credit_type->value);
            $i++;
            $next_due++;
        }

        $monthly_fixed = array_reduce($simulation, function ($a, $b) {
            return $a + floatval($b['main_capital']);
        }, 0);

        for ($i = 0; $i < count($simulation); $i++) {
            $simulation[$i]['fixed_monthly'] = $monthly_fixed / floatval($request->maturity);
        }

        $header_info = [
            'amount' => $request->amount,
            'scheduled_payment' => $amount / floatval($request->maturity),
            'tax' => $credit_type->tax,
            'fixed_monthly' => $monthly_fixed / $request->maturity,
            'maturity' => $i++,
            'company_logo' => Business::firstOrFail()->logo,
            'created_at' => $request->created_at
        ];

        return response()->json(['simulation' => $simulation, 'header_info' => $header_info], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLoanRequest $request)
    {
        $loan_check = Loan::where('customer_id', $request->customer_id)->where('status', 'disbursed')->first();
        if ($loan_check != null) {
            return response()->json(['error' => 'Operacao recusada, o cliente possue um emprestimo activo!'], 400);
        }
        $input = $request->only([
            'amount',
            'credit_type',
            'maturity',
            'created_at',
            'monthly_installment',
            'manager_id',
            'customer_id'
        ]);

        $input['user_id'] = $request->manager_id;

        $simulation = [];

        $credit_type = CreditType::find($request->credit_type);
        $anual_tax = $credit_type->tax;
        $anual_tax_decimal = $anual_tax / 100;
        $next_due = 1;
        $amount = floatval($request->amount);
        $final_balance = $amount;

        $i = 0;
        $total_fees = 0;
        while ($final_balance > 0) {
            $fees = floatval($final_balance) * $anual_tax_decimal;
            $tmp['final_balance'] = floatval($final_balance);
            $tmp['effective_payment'] = floatval($amount) / floatval($request->maturity);
            $tmp['index'] = $i + 1;
            $tmp['scheduled_date'] = LoanUtil::getScheduledDate($credit_type->type, $next_due);
            $final_balance = $final_balance - $tmp['effective_payment'];
            $tmp['fees'] = $fees;
            $tmp['main_capital'] = $tmp['effective_payment'] + $fees;
            array_push($simulation, $tmp);
            $next_due += intval($credit_type->value);
            $i++;
            $next_due++;
            $total_fees += $fees;
        }

        $monthly_fixed = array_reduce($simulation, function ($a, $b) {
            return $a + floatval($b['main_capital']);
        }, 0);

        for ($i = 0; $i < count($simulation); $i++) {
            $simulation[$i]['fixed_monthly'] = $monthly_fixed / floatval($request->maturity);
        }

        $input['created_by'] = auth('api')->user()->id;
        $input['total_fees'] = $total_fees;
        $input['fixed_monthly'] = $monthly_fixed / floatval($request->maturity);

        DB::beginTransaction();
        try {
            $loan = Loan::create($input);

            foreach ($request->warranties as $warranty) {
                $warranty = (object) $warranty;
                Warranty::create([
                    'created_by' => auth('api')->user()->id,
                    'description' => $warranty->description,
                    'cost' => $warranty->cost,
                    'value' => $warranty->value,
                    'loan_id' => $loan->id,
                    'acquisition_date' => $warranty->acquisition_date,
                ]);
            }


            DB::commit();

            return response()->json(['success' => 'Criado com sucesso!']);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            DB::rollback();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Loan::class);

        $loan = Loan::where('loans.id', $id)
            ->join('credit_types', 'credit_types.id', 'loans.credit_type')
            ->join('users', 'users.id', 'loans.user_id')
            ->select(
                'loans.*',
                'credit_types.name as credit_type_name',
                'credit_types.tax as tax',
                'credit_types.id as credit_type',
                'users.name as manager',
                'users.id as manager_id'
            )
            ->with('loan_transactions')
            ->first();

        return response()->json([
            'loan' => $loan,
            'customer' => Customer::where('id', $loan->customer_id)
                ->select(
                    'id',
                    'doc_nr',
                    'residence',
                    'activity',
                    'doc_type',
                    'phone',
                    'name',
                    'birthdate',
                    'nuit',
                    'city',
                    'address'
                )
                ->first(),
            'company_logo' => Business::firstOrFail()->logo,
            'manager' => User::where('id', $loan->user_id)
                ->select('id', 'name')
                ->first(),
            'schedule' => LoanSchedule::where('loan_id', $loan->id)
                ->with('loan_transaction')
                // ->select('id', 'name')
                ->get(),
            'warranties' => Warranty::where('loan_id', $id)->get(),
            'warranties_total_value' => Warranty::where('loan_id', $id)->sum('value'),
            'accounts' => DB::table('accounts')
                ->where('is_account', 1)
                ->where(function ($q) {
                    $q->where('master_parent_id', '1.2')
                        ->orWhere('master_parent_id', '1.1');
                })
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        if ($loan->status != 'requested') {
            return response()->json(['error' => 'Operacao recusada!'], 400);
        }

        $input = $request->only([
            'amount',
            'credit_type',
            'maturity',
            'created_at',
            'monthly_installment',
            'manager_id',
            'customer_id'
        ]);

        $input['created_by'] = auth('api')->user()->id;

        DB::beginTransaction();
        try {
            $warranties = Warranty::where('loan_id', $loan->id)->get();
            foreach ($warranties as $warranty) {
                $warranty->delete();
            }

            $loan->update($input);

            foreach ($request->warranties as $warranty) {
                $warranty = (object) $warranty;
                Warranty::create([
                    'created_by' => auth('api')->user()->id,
                    'description' => $warranty->description,
                    'cost' => $warranty->cost,
                    'value' => $warranty->value,
                    'loan_id' => $loan->id,
                    'acquisition_date' => $warranty->acquisition_date,
                ]);
            }

            DB::commit();

            return response()->json(['success' => 'Actualizado com sucesso!']);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            DB::rollback();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveOrDisapprove(Request $request)
    {
        $this->authorize('approve', Loan::class);
        $loan = Loan::find($request->id);

        if ($loan->status != 'requested') {
            return response()->json(['error' => 'Operacao recusada!'], 400);
        }
        try {
            Loan::where('id', $request->id)->update(['status' => $request->status]);
            DB::commit();
            return response()->json([
                'success' => 'Aprovado com sucesso!',
                'loan' => Loan::find($request->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disburse(Request $request)
    {
        $this->authorize('disburse', Loan::class);
        $loan = Loan::find($request->id);
        $customer = $loan->customer;
        $credit_type = CreditType::find($loan->credit_type);

        $amount = $loan->amount;
        $business = Business::firstOrFail();
        $charges = $business->charges_fee; //encargos

        $amounts = [
            'debit' => floatval($loan->amount) + floatval($loan->total_fees),
            'credit1' => floatval($amount) - ($amount * $charges / 100),
            'credit2' => $loan->total_fees,
            'credit3' => $amount * 5 / 100
        ];
        DB::beginTransaction();

        try {
            $simulation = [];

            $anual_tax = $credit_type->tax;
            $anual_tax_decimal = $anual_tax / 100;
            $next_due = 1;
            $amount = floatval($loan->amount);
            $final_balance = $amount;

            $i = 0;
            $total_fees = 0;
            while ($final_balance > 0) {
                $fees = floatval($final_balance) * $anual_tax_decimal;
                $tmp['final_balance'] = floatval($final_balance);
                $tmp['effective_payment'] = floatval($amount) / floatval($loan->maturity);
                $tmp['index'] = $i + 1;
                $tmp['scheduled_date'] = LoanUtil::getScheduledDate($credit_type->type, $next_due);
                $final_balance = $final_balance - $tmp['effective_payment'];
                $tmp['fees'] = $fees;
                $tmp['main_capital'] = $tmp['effective_payment'] + $fees;
                array_push($simulation, $tmp);
                $next_due += intval($credit_type->value);
                $i++;
                $next_due++;
                $total_fees += $fees;
            }

            $monthly_fixed = array_reduce($simulation, function ($a, $b) {
                return $a + floatval($b['main_capital']);
            }, 0);

            for ($i = 0; $i < count($simulation); $i++) {
                $simulation[$i]['fixed_monthly'] = $monthly_fixed / floatval($loan->maturity);
            }


            ################## Adding Schedules ########################

            foreach ($simulation as $row) {
                LoanSchedule::create([
                    'description' => $row['index'] . 'ª Prestação',
                    'loan_id' => $loan->id,
                    'scheduled_date' => Carbon::create($row['scheduled_date']),
                    'created_by' => auth('api')->user()->id,
                    'scheduled_payment' => $row['effective_payment'],
                    'residual' => $row['final_balance'],
                    'capital_fee' => $row['fees'],
                    'customer_id' => $loan->customer->id,
                    'total_monthly' => $row['fees'] + $row['effective_payment'],
                    'fixed_monthly' => $row['fixed_monthly']
                ]);
            }

            ################## END Schedules #######################

            $account = Account::where('id', $customer->account_id)->firstOrFail();
            LoanUtil::castDisburse('Desembolso ' . $loan->code, $amounts, $request->created_at, $request->id, $request->account_id, $account->id, 1);
            Loan::where('id', $request->id)->update(['status' => 'disbursed', 'disbursed_at' => $request->created_at, 'disbursed_amount' => $request->disbursed_amount]);

            DB::commit();

            return response()->json([
                'success' => 'Deseembolsado com sucesso!',
                'loan' => Loan::find($request->id)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response($e, 500);
        }
    }

    public function restruct(Request $request)
    {
        $this->authorize('restruct', Loan::class);
        $loan = Loan::find($request->id);
        $total_fees = Loan::totaLFees((object) [
            'maturity' => $loan->maturity,
            'amount' => $request->disbursed_amount,
            'credit_type' => $loan->credit_type
        ]);

        $payed_fee = Loans_transaction::where('loan_id', $request->id)->sum('fees');

        $total_payed_installments = Loans_transaction::where('loan_id', $request->id)->sum('effective_payment');

        $new_disbursed_amount = floatval($loan->disbursed_amount) - floatval($total_payed_installments);

        $new_total_fees = Loan::totaLFees((object) [
            'maturity' => $request->maturity,
            'amount' => $new_disbursed_amount,
            'credit_type' => $loan->credit_type
        ]);

        $accountB = Account::where('uuid', '4.9.1.1.1')->firstOrFail(); # Juros a Receber de Creditos Concedidos
        $accountA = Account::where('uuid', '4.1.1.1')->firstOrFail(); #  Créditos Concedidos
        $accountC = Account::where('uuid', '4.1.1.2')->firstOrFail(); #  créditos Cencedidos (Reestruturado)


        ##################################### First cast ################################################

        $last = DB::table('divers')->whereNull('deleted_at')->select('ref')->latest('id')->first();
        if ($last == null) {
            $year_and_month = explode('-', $request->created_at)[0] . '-' . explode('-', $request->created_at)[1];
            $total_records = DB::table('divers')->whereNull('deleted_at')->where('divers.created_at', 'like', '%' . $year_and_month . '%')->count('*');
            $ref = explode('-', $request->created_at)[0] . '' . explode('-', $request->created_at)[1] . '' . str_pad($total_records + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $ref = $last->ref;
        }
        DB::beginTransaction();
        try {
            $divers_first_cast = Divers::create([
                'created_by' => Auth::id(),
                'name' =>  'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'ref' => $ref + 1,
                'description' =>  'Reestruturação​  do crédito ' . $loan->code,
                'debit_acc_id' => $accountB->id,
                'credit_acc_id' => $accountA->id,
                'created_at' => $request->created_at,
            ]);

            Util::encrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'divers_id' => $divers_first_cast->id,
                'account_id' => $accountB->id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'divers_id' => $divers_first_cast->id,
                'account_id' => $accountA->id,
                'date' => $request->created_at,
            ]);


            ######################################## END ####################################################

            ##################################### Second cast ################################################

            $divers_second_cast = Divers::create([
                'created_by' => Auth::id(),
                'name' =>  'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_disbursed_amount),
                'ref' => $ref + 2,
                'description' =>  'Reestruturação​  do crédito ' . $loan->code,
                'debit_acc_id' => $accountC->id,
                'credit_acc_id' => $accountA->id,
                'created_at' => $request->created_at,
            ]);

            Util::encrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_disbursed_amount),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'divers_id' => $divers_second_cast->id,
                'account_id' => $accountC->id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_disbursed_amount),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'divers_id' => $divers_second_cast->id,
                'account_id' => $accountA->id,
                'date' => $request->created_at,
            ]);


            ######################################## END ####################################################

            ##################################### Third cast ################################################

            $divers_third_cast = Divers::create([
                'created_by' => Auth::id(),
                'name' =>  'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'ref' => $ref + 3,
                'description' =>  'Reestruturação​  do crédito ' . $loan->code,
                'debit_acc_id' => $accountC->id,
                'credit_acc_id' => $accountB->id,
                'created_at' => $request->created_at,
            ]);

            Util::encrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'divers_id' => $divers_third_cast->id,
                'account_id' => $accountC->id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => 'Reestruturação​  do crédito ' . $loan->code,
                'amount' => floatval($new_total_fees),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'divers_id' => $divers_third_cast->id,
                'account_id' => $accountB->id,
                'date' => $request->created_at,
            ]);


            ######################################## END ####################################################

            Loan::find($request->id)->update(['status' => 'finished']);
            $input = [
                'amount' => $new_disbursed_amount,
                'credit_type' => $loan->credit_type,
                'maturity' => $request->maturity,
                'created_at' => $request->created_at,
                'monthly_installment' => $loan->monthly_installment,
                'manager_id' => $loan->manager_id,
                'customer_id' => $loan->customer_id,
                'status' => 'disbursed',
                'disbursed_at' => $request->created_at,
                'disbursed_amount' => $new_disbursed_amount
            ];

            $input['created_by'] = Auth::id();


            $new_loan = Loan::create($input);
            $warranties = Warranty::where('loan_id', $request->id)->select('id')->get();

            foreach ($warranties as $warranty) {
                $warranty = (object) $warranty;
                Warranty::find($warranty->id)->update([
                    'created_by' => Auth::id(),
                    'loan_id' => $new_loan->id
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => 'Reestruturado com sucesso!',
                'loan' => Loan::find($new_loan->id)
            ]);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            DB::rollback();
            return response($e->getMessage(), 500);
        }
    }
    public function forget_loan(Request $request)
    {
        $this->authorize('close', Loan::class);
        $loan = Loan::find($request->id);
        $total_fees = Loan::totaLFees((object) [
            'maturity' => $loan->maturity,
            'amount' => $loan->disbursed_amount,
            'credit_type' => $loan->credit_type
        ]);

        $payed_fee = Loans_transaction::where('loan_id', $request->id)->sum('fees');
        $missing_fees = floatval($total_fees) - floatval($payed_fee);

        $total_payed_installments = Loans_transaction::where('loan_id', $request->id)->sum('effective_payment');

        $missing_disbursed_amount = floatval($loan->disbursed_amount) - floatval($total_payed_installments);
        $missing_payment = floatval($missing_fees) + floatval($missing_disbursed_amount);

        $accountB = Account::where('uuid', '4.9.1.1.1')->firstOrFail(); # Juros a Receber de Creditos Concedidos
        $accountA = Account::where('uuid', '4.1.1.1')->firstOrFail(); #  Créditos Concedidos
        $accountC = Account::where('uuid', '6.9.1.1')->firstOrFail(); #   Empréstimos bancários


        ##################################### First cast ################################################

        $last = DB::table('divers')->whereNull('deleted_at')->select('ref')->latest('id')->first();
        if ($last == null) {
            $year_and_month = explode('-', $request->created_at)[0] . '-' . explode('-', $request->created_at)[1];
            $total_records = DB::table('divers')->whereNull('deleted_at')->where('divers.created_at', 'like', '%' . $year_and_month . '%')->count('*');
            $ref = explode('-', $request->created_at)[0] . '' . explode('-', $request->created_at)[1] . '' . str_pad($total_records + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $ref = $last->ref;
        }
        DB::beginTransaction();
        try {
            $divers_first_cast = Divers::create([
                'created_by' => Auth::id(),
                'name' =>  'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_disbursed_amount),
                'ref' => $ref + 1,
                'description' =>  'Abate do crédito ' . $loan->code,
                'debit_acc_id' => $accountC->id,
                'credit_acc_id' => $accountA->id,
                'created_at' => $request->created_at,
            ]);

            Util::encrease((object) [
                'description' => 'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_disbursed_amount),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'divers_id' => $divers_first_cast->id,
                'account_id' => $accountC->id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => 'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_disbursed_amount),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'divers_id' => $divers_first_cast->id,
                'account_id' => $accountA->id,
                'date' => $request->created_at,
            ]);


            ######################################## END ####################################################

            ##################################### Second cast ################################################

            $divers_second_cast = Divers::create([
                'created_by' => Auth::id(),
                'name' =>  'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_payment),
                'ref' => $ref + 2,
                'description' =>  'Abate do crédito ' . $loan->code,
                'debit_acc_id' => $accountB->id,
                'credit_acc_id' => $accountA->id,
                'created_at' => $request->created_at,
            ]);

            Util::encrease((object) [
                'description' => 'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_payment),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'divers_id' => $divers_second_cast->id,
                'account_id' => $accountB->id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => 'Abate do crédito ' . $loan->code,
                'amount' => floatval($missing_payment),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'divers_id' => $divers_second_cast->id,
                'account_id' => $accountA->id,
                'date' => $request->created_at,
            ]);


            ######################################## END ####################################################
            Loan::where('id', $request->id)->update(['status' => 'canceled']);

            DB::commit();

            return response()->json([
                'success' => 'Abatido com sucesso!',
                'loan' => Loan::find($loan->id)
            ]);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            DB::rollback();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->authorize('view', Loan::class);
        $total = Loan::sum('amount');
        $total_disbursed = Loan::where('status', 'disbursed')->sum('amount');
        $total_paid = LoanSchedule::whereNotNull('effective_date')->sum('fixed_monthly');
        $total_delayed = Loan::where('delayed_status', 1)->sum('amount');
        $total_pending = Loan::where('status', 'requested')->sum('amount');
        $total_customers = Customer::count('*');

        $current_month = \Carbon\Carbon::now()->month;

        $schs = LoanSchedule::whereMonth('scheduled_date', $current_month)
            ->join('customers', 'customers.id', 'loan_schedules.customer_id')
            ->select('loan_schedules.*', 'customers.name as customer')
            ->get();

        $dashboard = [
            'total' => $total,
            'total_delayed' => $total_delayed,
            'total_paid' => $total_paid,
            'disbursed' => $total_disbursed,
            'pending' => $total_pending,
            'customers' => $total_customers,
            'installments' => $schs
        ];

        return response()->json($dashboard);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reports_filter(Request $request)
    {
        // we need to get total paid, nr os installments

        $loans = Loan::where('status', 'disbursed')->join('customers', 'customers.id', 'loans.customer_id')
            ->join('loan_schedules', 'loan_schedules.loan_id', 'loans.id')
            ->whereBetween('loans.created_at', [$request->from, $request->to]);

        $manager = request()->get('manager', null);
        if (!empty($manager)) {
            $loans = $loans->where('laons.manager_id', $manager);
        }

        $type = request()->get('type', null);
        if (!empty($type)) {
            if ($type === 'in_delay') {
                $loans = $loans->where('loans.delayed_status', 1);
            }
        }

        $loans = $loans->select(
            'loans.code',
            'loans.id',
            'loans.disbursed_at',
            'loans.disbursed_amount',
            'loans.maturity',
            'loans.total_fees',
            'customers.name as customer',
            DB::raw('COUNT("loans.loan_schedules") AS total_installments'),
            DB::raw("SUM((SELECT COALESCE(SUM(ls.fixed_monthly), 0) FROM loan_schedules as ls WHERE ls.effective_date IS NOT NULL)) as total_paid"),
        )
            ->with(['loan_schedules'])
            ->groupBy('loans.id')
            ->get();

        $loans_prepared = [];
        $current_month = \Carbon\Carbon::now()->month;

        if ($type === 'active') {
            foreach ($loans as $loan) {
                foreach ($loan->loan_schedules as $lsc) {
                    $installment_month = \Carbon\Carbon::parse($lsc->scheduled_date)->month;
                    if ($current_month === $installment_month) {
                        array_push($loans_prepared, (array) $loan);
                        break;
                    }
                }
            }
        }

        return response()->json(['loans' => !empty($loans_prepared) ? $loans_prepared : $loans]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}