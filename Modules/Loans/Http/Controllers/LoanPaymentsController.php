<?php

namespace Modules\Loans\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Loans\Entities\Loan;
use Modules\Loans\Utils\Util;
use Modules\Loans\Entities\LoanTransaction;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\Journal;
use Modules\Base\Entities\Permission;
use Modules\Business\Entities\Business;
use Modules\Business\Entities\Payment;
use Modules\Customers\Entities\Customer;
use Modules\Loans\Entities\LoanSchedule;
use Modules\Loans\Utils\LoanUtil;

class LoanPaymentsController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', LoanTransaction::class);
        return response()->json([
            'accounts' => DB::table('accounts')
                ->where(function ($q) {
                    $q->where('master_parent_id', '1.2')
                        ->orWhere('master_parent_id', '1.1');
                })
                ->get(),
            'loans' => Loan::where('status', 'disbursed')->select('id', 'code')->get(),
            'payments' => LoanTransaction::join('loans', 'loans.id', 'loan_transactions.loan_id')
                ->join('customers', 'loans.customer_id', 'customers.id')
                ->select('loan_transactions.*', 'loans.code as loan', 'customers.name as customer')->get()
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments()
    {
        $this->authorize('view', LoanTransaction::class);
        return response()->json([
            'accounts' => DB::table('accounts')
                ->where(function ($q) {
                    $q->where('master_parent_id', '1.2')
                        ->orWhere('master_parent_id', '1.1');
                })
                ->get(),
            'loans' => Loan::where('status', 'disbursed')->select('id', 'code')->get(),
            'payments' => Payment::join('customers', 'payments.customer_id', 'customers.id')
                ->select('payments.*', 'customers.name as customer')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments_bill($id)
    {
        $this->authorize('view', LoanTransaction::class);
        $business = Business::firstOrFail();
        $payment = Payment::findOrFail($id);
        $customer = $payment->customer;
        $installments = LoanSchedule::where('customer_id', $customer->id)->get();
        $total_paid = LoanSchedule::whereNotNull('effective_date')->sum('fixed_monthly');
        $total_to_pay = LoanSchedule::sum('fixed_monthly');
        $total_fees = LoanSchedule::sum('delay_fees');

        return response()->json([
            'business' => $business,
            'payment' => $payment,
            'customer' => $customer,
            'installments' => $installments,
            'total_to_pay' => $total_to_pay,
            'total_paid' => $total_paid,
            'total_fees' => $total_fees,
        ]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Debitar bancos ou caixa
        // Creditar clientes
        // No reconhecimento automatico, simplesmente actualizamos em funcao do valor disponivel na conta do cliente
        $this->authorize('create', LoanTransaction::class);

        DB::beginTransaction();

        try {

            $loan = Loan::where('customer_id', $request->customer_id)
                ->where('status', 'disbursed')
                ->firstOrFail();

            if ($loan === null) {
                return response()->json(['error' => 'O cliente nao possue nenhum emprestimo activo.']);
            }
            $customer = $loan->customer;
            $customer_account = Account::where('id', $customer->account_id)->firstOrFail();

            $next_payment = LoanUtil::customerNextPaymentSchedule($request->customer_id);
            $description = 'Reembolso da ' . $next_payment->description . ' do credito ' . $loan->code;

            $payment = Payment::create([
                'amount' => floatval($request->effective_payment),
                'method' => $request->payment_method,
                'payment_date' => $request->created_at,
                'loan_scheduled_id' => $next_payment->id,
                'loan_id' => $loan->id,
                'ref_payment' => $request->ref_payment,
                'customer_id' => $request->customer_id,
                'notes' => $request->description,
                'created_by' => auth()->id()
            ]);

            Customer::increaseBalance($request->customer_id, floatval($request->effective_payment));

            LoanUtil::castLoanPayment($description, $request->account_id, $customer_account->id, floatval($request->effective_payment), $request->created_at, $loan->id, $request->customer_id, $payment);



            //LoanSchedule::findOrFail($next_payment->id)->update(['effective_date' => ])

            //$input['journal_id'] = $journal->id;

            //LoanTransaction::create($input);

            // if ($input['final_balance'] <= 0) {
            //     Loan::find($request->loan)->update(['status' => 'finished']);
            // }

            DB::commit();

            return response()->json([
                'success' => 'Efectuado com sucesso!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
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
        $this->authorize('view', LoanTransaction::class);
        return response()->json(LoanTransaction::join('loans', 'loans.id', 'loans_transactions.loan_id')
            ->join('divers', 'divers.id', 'loans_transactions.divers_id')
            ->select('loans_transactions.*', 'loans.code as loan', 'divers.debit_acc_id as account_id')
            ->first($id));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function next_payment($id)
    {
        $this->authorize('view', LoanTransaction::class);

        $loan = Loan::where('customer_id', $id)
            ->where('status', 'disbursed')
            ->first();

        if ($loan === null) {
            return response()->json(['error' => 'O cliente nao possue nenhum emprestimo activo.'], 400);
        }
        // get client
        $next_payment = LoanUtil::customerNextPaymentSchedule($id);

        return response()->json($next_payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', LoanTransaction::class);
        $input = LoanTransaction::transactionData($request);

        $accountA = Account::where('uuid', '4.1.1.1')->firstOrFail();
        $loans_transaction = LoanTransaction::find($id);
        # END MATHS

        DB::beginTransaction();

        Util::rollbackTransactionAccount('journal_id', $loans_transaction->journal_id);

        try {

            $journal = Journal::find($loans_transaction->journal_id)->update([
                'amount' => floatval($input['main_capital']) + floatval($input['fees']),
                'description' => 'Abate do crédito ' . $loan->code,
                'location_id' => 1,
                'journal_type_id' => 1,
                'created_at' => $request->created_at,
                'created_by' => Auth::id()
            ]);

            Util::increase((object) [
                'description' => $request->description,
                'amount' => floatval($input['main_capital']) + floatval($input['fees']),
                'type' => 'debit',
                'operation' => 'sum',
                'payment_method' => 'other',
                'journal_id' => $journal->id,
                'location_id' => 1,
                'journal_type_id' => 1,
                'account_id' => $request->account_id,
                'date' => $request->created_at,
            ]);

            Util::decrease((object) [
                'description' => $request->description,
                'amount' => floatval($input['main_capital']) + floatval($input['fees']),
                'type' => 'credit',
                'operation' => 'sub',
                'payment_method' => 'other',
                'journal_id' => $journal->id,
                'cost_center_id' => 1,
                'journal_type_id' => 1,
                'account_id' => $accountA->id,
                'date' => $request->created_at,
            ]);

            LoanTransaction::find($id)->update($input);

            DB::commit();

            return response()->json([
                'success' => 'Modificado com sucesso!',
                'loan' => Loan::find($request->id)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
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
    public function destroy($id)
    {
        $this->authorize('delete', LoanTransaction::class);
    }
}
