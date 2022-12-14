<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountTransaction;
use Modules\Customers\Entities\Customer;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'notes',
        'type',
        'created_by',
        'account_number',
        'initial_balance',
        'class_id',
        'is_parent',
        'uuid',
        'parent_id',
        'master_parent_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\AccountFactory::new();
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    // pass account UUID and return the corresponnding ID account
    public static function getIdFromUUID($uuid)
    {
        $account = Account::where('uuid', $uuid)->select('type', 'id')->first();
        if ($account != null) {
            return $account->id;
        }
        return null;
    }

    public static function isValid($id)
    {
        $account = Account::find($id);
        $has_sons = Account::where('parent_id', $account->uuid)->whereNull('deleted_at')->get();

        if ($account->is_account == 1 && count($has_sons) <= 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function totalBalance($column, $id)
    {

        $amount = 0;
        $has_sons = Account::where('master_parent_id', $id)->first();

        if ($has_sons != null) {
            $accounts = Account::where($column, $id)->get();

            foreach ($accounts as $acc) {
                $amount += $acc->balance;
            }
        }

        if ($has_sons == null) {
            $amount = DB::table('accounts')->where('uuid', $id)->sum('balance');
        }



        return $amount;
    }

    public static function transactions($id, $amount, $type, $date, $payment_id = null, $operation = null, $notes = null, $bill_id = null)
    {
        $account = Account::find($id);
        $final_balance = DB::table('account_transactions')->whereNull('deleted_at')->where('account_id', $id)->latest('id')->first();
        $final_balance = $final_balance !== null ? $final_balance->final_amount : 0;

        if ($type == 'debit') {
            $final_balance = floatval($account->balance) + floatval($amount);
        } else {
            $final_balance = floatval($account->balance) - floatval($amount);
        }

        AccountTransaction::create([
            'created_by' => auth('api')->user()->id,
            'amount' => $amount,
            'initial_amount' => $account->balance,
            'final_amount' => $final_balance,
            'account_id' => $id,
            'notes' => $notes,
            'type' => $type, //5033g
            'payment_id' => $payment_id,
            'bill_id' => $bill_id
        ]);

        if ($operation == 'sub') {
            DB::table('accounts')->where('id', $id)->decrement('balance', $final_balance);
        } else {
            DB::table('accounts')->where('id', $id)->increment('balance', $final_balance);
        }
    }
}