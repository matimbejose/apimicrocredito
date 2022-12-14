<?php

namespace Modules\Accounting\Utils;

use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountClosing;
use Modules\Accounting\Entities\AccountTransaction;

class Util
{

    /**
     * decrease product quantity.
     */
    public static function decrease($data = [])
    {
        $data = (object) $data;
        $account = DB::table('accounts')->where('id', $data->account_id)->first()->balance;

        $last_balance = DB::table('account_transactions')->whereNull('deleted_at')->where('account_id', $data->account_id)->latest('id')->first();
        $last_balance = $last_balance !== null ? $last_balance->final_amount : 0;
        $l_data = [
            'description' => isset($data->description) ? $data->description : null,
            'initial_amount' => isset($account) ? $account : null,
            'amount' => isset($data->amount) ? $data->amount : null,
            'final_amount' => $data->type == 'debit' ? floatval($last_balance) + floatval($data->amount) : floatval($last_balance) - floatval($data->amount),
            'account_id' => isset($data->account_id) ? $data->account_id : null,
            'type' => isset($data->type) ? $data->type : null,
            'operation' => isset($data->operation) ? $data->operation : null,
            'bill_id' => isset($data->bill_id) ? $data->bill_id : null,
            'loan_id' => isset($data->loan_id) ? $data->loan_id : null,
            'journal_id' => isset($data->journal_id) ? $data->journal_id : null,
            'journal_type_id' => isset($data->journal_type_id) ? $data->journal_type_id : null,
            'cost_center_id' => isset($data->cost_center_id) ? $data->cost_center_id : null,
            'invoice_id' => isset($data->invoice_id) ? $data->invoice_id : null,
            'customer_id' => isset($data->customer_id) ? $data->customer_id : null,
            'transaction_id' => isset($data->transaction_id) ? $data->transaction_id : null,
            'created_at' => $data->date !== '' ? $data->date : date('Y-m-d h:i:s'),
            'created_by' => auth('api')->user()->id
        ];

        DB::table('account_transactions')->insert($l_data);
        DB::table('accounts')->where('id', $data->account_id)->decrement('balance', $data->amount);

        if (isset($data->customer_id)) {
            DB::table('customers')->where('id', $data->customer_id)->decrement('balance', $data->amount);
        }
    }

    public static function increase($data = [])
    {
        $data = (object) $data;
        $account = DB::table('accounts')->where('id', $data->account_id)->first()->balance;
        $last_balance = DB::table('account_transactions')->whereNull('deleted_at')->where('account_id', $data->account_id)->latest('id')->first();
        $last_balance = $last_balance !== null ? $last_balance->final_amount : 0;
        $e_data = [
            'description' => isset($data->description) ? $data->description : null,
            'initial_amount' => isset($account) ? $account : null,
            'amount' => isset($data->amount) ? $data->amount : null,
            'final_amount' => $data->type == 'debit' ? floatval($last_balance) + floatval($data->amount) : floatval($last_balance) - floatval($data->amount),
            'account_id' => isset($data->account_id) ? $data->account_id : null,
            'type' => isset($data->type) ? $data->type : null,
            'operation' => isset($data->operation) ? $data->operation : null,
            'loan_id' => isset($data->loan_id) ? $data->loan_id : null,
            'bill_id' => isset($data->bill_id) ? $data->bill_id : null,
            'journal_id' => isset($data->journal_id) ? $data->journal_id : null,
            'invoice_id' => isset($data->invoice_id) ? $data->invoice_id : null,
            'journal_type_id' => isset($data->journal_type_id) ? $data->journal_type_id : null,
            'cost_center_id' => isset($data->cost_center_id) ? $data->cost_center_id : null,
            'customer_id' => isset($data->customer_id) ? $data->customer_id : null,
            'transaction_id' => isset($data->transaction_id) ? $data->transaction_id : null,
            'created_at' => $data->date !== '' ? $data->date : date('Y-m-d h:i:s'),
            'created_by' => auth('api')->user()->id
        ];


        DB::table('account_transactions')->insert($e_data);
        // DB::table('extracts')->insert($e_data); expense_cat_id
        DB::table('accounts')->where('id', $data->account_id)->increment('balance', $data->amount);


        if (isset($data->customer_id)) {
            DB::table('customers')->where('id', $data->customer_id)->increment('balance', $data->amount);
        }
    }

    public static function closeAccounts($request, $result_acc, $own_acc)
    {
        // fecho de contas anuais
        $incomes_accounts = Account::where('class_id', '7')->select('balance', 'id')->get();
        $costs_accounts = Account::where('class_id', '6')->select('balance', 'id')->get();
        //dd($incomes_accounts);
        $total_incomes = Account::where('class_id', '7')->select('balance')->sum('balance');
        $total_costs = Account::where('class_id', '6')->select('balance')->sum('balance');
        $period_r = floatval($total_incomes) - floatval($total_costs);

        $accs = Account::select('balance', 'uuid', 'id')->get();
        foreach ($accs as $acc) {
            AccountClosing::create([
                'created_by' => auth('api')->user()->id,
                'uuid' => $acc->uuid,
                'account_id' => $acc->id,
                'balance' => $acc->balance,
                'year' => explode('-', $request->created_at)[0]
            ]);
        }

        //  DB::beginTransaction();
        //try {
        #################################### First Cast ###################################
        // zerar contas de proveito contas de proveito
        $journal = Journal::create([
            'ref' => $request->ref,
            'amount' => $total_incomes,
            'description' => $request->description,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'created_at' => $request->created_at,
            'created_by' => auth('api')->user()->id
        ]);

        foreach ($incomes_accounts as $acc) {
            Util::decrease((object) [
                'description' => $request->description,
                'amount' => $acc->balance,
                'type' => 'debit',
                'operation' => 'sub',
                'journal_id' => $journal->id,
                'cost_center_id' => $request->cost_center,
                'journal_type_id' => $request->journal_type,
                'account_id' => $acc->id,
                'date' => $request->created_at,
                'payment_method' => 'other',
            ]);
        }
        // Credito
        Util::encrease((object) [
            'description' => $request->description,
            'amount' => $total_incomes,
            'type' => 'credit',
            'operation' => 'sum',
            'journal_id' => $journal->id,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'account_id' => $result_acc,
            'date' => $request->created_at,
            'payment_method' => 'other',
        ]);

        ############################# END ######################################


        ######################### Second cast ###################################
        // zerar contas de custos
        $journal2 = Journal::create([
            'ref' => $request->ref + 1,
            'amount' => $total_costs,
            'description' => $request->description,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'created_at' => $request->created_at,
            'created_by' => auth('api')->user()->id
        ]);

        foreach ($costs_accounts as $acc) {
            // caso positivas creditam     (proveitos == passivos , custos == activos)  
            Util::decrease((object) [
                'description' => $request->description,
                'amount' => $acc->balance,
                'type' => 'credit',
                'operation' => 'sub',
                'journal_id' => $journal2->id,
                'cost_center_id' => $request->cost_center,
                'journal_type_id' => $request->journal_type,
                'account_id' => $acc->id,
                'date' => $request->created_at,
                'payment_method' => 'other',
            ]);
        }
        // Credito
        Util::decrease((object) [
            'description' => $request->description,
            'amount' => $total_incomes,
            'type' => 'debit',
            'operation' => 'sum',
            'journal_id' => $journal2->id,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'account_id' => $result_acc,
            'date' => $request->created_at,
            'payment_method' => 'other',
        ]);

        ######################### Third cast ###################################

        $journal3 = Journal::create([
            'ref' => $request->ref + 2,
            'amount' => $period_r,
            'description' => $request->description,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'created_at' => $request->created_at,
            'created_by' => auth('api')->user()->id
        ]);
        // debito
        Util::decrease((object) [
            'description' => $request->description,
            'amount' => $period_r,
            'type' => 'debit',
            'operation' => 'sub',
            'journal_id' => $journal3->id,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'account_id' => $result_acc,
            'date' => $request->created_at,
            'payment_method' => 'other',
        ]);
        // credito
        Util::encrease((object) [
            'description' => $request->description,
            'amount' => $period_r,
            'type' => 'credit',
            'operation' => 'sum',
            'journal_id' => $journal3->id,
            'cost_center_id' => $request->cost_center,
            'journal_type_id' => $request->journal_type,
            'account_id' => $own_acc,
            'date' => $request->created_at,
            'payment_method' => 'other',
        ]);


        // DB::commit();

        //} catch (\Exception $e) {
        //  DB::rollback();
        //\Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

        //  return response($e, 500);
        //}
    }

    public static function set_log($log)
    {
        activity()
            ->causedBy(auth('api')->user()->id)
            ->withProperties(['user' => Auth::user()->username])
            ->log($log);
    }

    public static function accountTransactionsSync($table, $identifier, $acc_id, $culumn = null)
    {

        $last_value = 0;
        $first = true;

        if ($culumn == null) {
            $extracts = DB::table($table)
                ->where($identifier, $acc_id)
                ->orderBy('created_at', 'ASC')
                ->get();
        } else {
            $extracts = DB::table($table)
                ->where($identifier, $acc_id)
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'ASC')
                ->get();
        }


        foreach ($extracts as $extract) {
            if ($extract->type == 'debit') {

                DB::table($table)->where('id', $extract->id)->update([
                    $culumn == null ? 'inicial_amount' : 'initial_amount' => $first == true ? 0 : $last_value,
                    $culumn == null ? 'balance' : 'final_amount' => $last_value + $extract->amount,
                ]);
                $last_value = $last_value + $extract->amount;
            } else {
                DB::table($table)->where('id', $extract->id)->update([
                    $culumn == null ? 'inicial_amount' : 'initial_amount' => $first == true ? 0 : $last_value,
                    $culumn == null ? 'balance' : 'final_amount' => $last_value - $extract->amount,
                ]);
                $last_value = $last_value - $extract->amount;
            }
            $first = false;
        }
    }

    public static function ac_accountTransactionsSync($id)
    {

        $extracts = DB::table('account_transactions')
            ->whereNull('deleted_at')
            ->where('account_id', $id)
            ->get();

        $last_value = 0;

        foreach ($extracts as $extract) {
            if ($extract->type == 'credit') {

                DB::table('account_transactions')->where('id', $extract->id)->update([
                    'initial_amount' => $last_value,
                    'final_amount' => $last_value - $extract->amount,
                ]);
                $last_value = $last_value - $extract->amount;
            } else {
                DB::table('account_transactions')->where('id', $extract->id)->update([
                    'initial_amount' => $last_value,
                    'final_amount' => $last_value + $extract->amount,
                ]);
                $last_value = $last_value + $extract->amount;
            }
        }
    }

    /**
     *
     * Generates string to calculate sum of purchase line quantity used
     */
    public function get_pl_quantity_sum_string($table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name . '.' : '';
        $string = $table_name . "quantity_sold + " . $table_name . "quantity_adjusted + " . $table_name . "quantity_returned";

        return $string;
    }

    public static function rollbackTransactionAccount($identifier, $id)
    {

        $account_transactions = Transactions_account::where($identifier, $id)->get();
        foreach ($account_transactions as $trans) {
            if ($trans->operation == 'sum') {
                Account::find($trans->account_id)->decrement('balance', $trans->amount);
            } else {
                Account::find($trans->account_id)->increment('balance', $trans->amount);
            }
            $trans->delete();
        }
    }

    public static function dashboardClassAciveOrPassive($type, $class)
    {
        $total_class = 0;
        $prev_total_class = 0;
        $processed_class = [];
        $classData = Account::where('class_id', $class)->where('parent_id', null)->select('uuid', 'balance', 'type')->get();
        // $last_transaction_date = AccountTransaction::select('created_at')->latest('created_at')->first();
        $acc_closings = AccountClosing::select('year')->latest('id')->first();
        foreach ($classData as $value) {
            $sub_prev_class_total = 0;
            if ($acc_closings == null) {
                $sub_class_subs = Account::where('master_parent_id', $value->uuid)->where('type', $type)->select('id', 'uuid', 'type', 'balance', 'name')->orderBy('uuid')->get();
            } else {
                $sub_class_subs = Account::where('accounts.master_parent_id', $value->uuid)->where('accounts.type', $type)
                    ->join('account_closings', function ($join) use ($acc_closings) {
                        $join->on('account_closings.account_id', '=', 'accounts.id')
                            ->where('account_closings.year', '=', $acc_closings->year);
                    })
                    ->select(
                        'accounts.id',
                        'accounts.uuid',
                        'accounts.balance',
                        'accounts.type',
                        'accounts.name',
                        'account_closings.balance as prev_balance'
                    )
                    ->orderBy('accounts.uuid')
                    ->get();

                foreach ($sub_class_subs as $item) {
                    $sub_prev_class_total += $item->prev_balance;
                }
            }

            $sub_class_name = Account::where('uuid', $value->uuid)->select('name', 'uuid')->first();
            $sub_class_total = Account::where('master_parent_id', $value->uuid)->where('type', $type)->sum('balance');
            $total = floatval($sub_class_total) + floatval($value->balance);
            $tmp['type'] = $value->type;
            $tmp['name'] = join('', explode('.', $value->uuid)) . ' - ' . $sub_class_name->name;
            $tmp['total'] = $total;
            $tmp['prev_total'] = $sub_prev_class_total;
            $tmp['accounts'] = $sub_class_subs;

            $total_class += $total;
            $prev_total_class += $sub_prev_class_total;

            if ($total > 0 || $total < 0) {
                array_push($processed_class, $tmp);
            }
        }
        return  [
            'total' => $total_class,
            'prev_total' => $prev_total_class,
            'data' => $processed_class,

        ];
    }
}