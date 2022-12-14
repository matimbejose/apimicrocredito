<?php

namespace Modules\Loans\Utils;

use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountTransaction;

class Util
{

    /**
     * decrease product quantity.
     */
    public static function decrease($data)
    {

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
            'created_by' => !empty(auth('api')->user()->id) ? auth('api')->user()->id : 1
        ];

        DB::table('account_transactions')->insert($l_data);
        DB::table('accounts')->where('id', $data->account_id)->decrement('balance', $data->amount);
    }

    public static function encrease($data)
    {
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
            'created_by' => !empty(auth('api')->user()->id) ? auth('api')->user()->id : 1
        ];


        DB::table('account_transactions')->insert($e_data);
        // DB::table('extracts')->insert($e_data); expense_cat_id
        DB::table('accounts')->where('id', $data->account_id)->increment('balance', $data->amount);
    }

    public static function rollbackTransactionAccount($identifier, $id)
    {

        $account_transactions = AccountTransaction::where($identifier, $id)->get();
        foreach ($account_transactions as $trans) {
            if ($trans->operation == 'sum') {
                Account::find($trans->account_id)->decrement('balance', $trans->amount);
            } else {
                Account::find($trans->account_id)->increment('balance', $trans->amount);
            }
            $trans->delete();
        }
    }
}