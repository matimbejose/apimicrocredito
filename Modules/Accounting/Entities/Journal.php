<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Utils\Util;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'amount', 'description', 'payment_id',
        'ref', 'created_at', 'loan_id', 'transaction_id',
        'created_by', 'journal_type_id', 'cost_center_id', 'bill_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\JournalFactory::new();
    }

    public static function requestVerification($request)
    {
        $transanction_lines = $request['transactionLines'];
        foreach ($transanction_lines as $transaction) {
            $transaction = (object) $transaction;

            if (strpos($transaction->account, '-')) {
                $account_formated = explode('-', $request->result_account)[0];
                $account_formated = implode('.', str_split($account_formated));
            } else {
                $account_formated = join('.', str_split($transaction->account));
            }
            $account = Account::where('uuid', $account_formated)->select('type', 'id')->first();
            if ($account ==  null) {
                return response()->json(['error' => 'Uma ou mais conta não e valida'], 400);
            }
            // Verificar se os valores informados sao maiores que 0
            if ($transaction->debit <= 0 && $transaction->credit <= 0) {
                return response()->json(['error' => 'Montantes invalidos!'], 400);
            }
            // Verificar se os valores informados sao maiores que 0
            if ($transaction->debit != $transaction->credit) {
                return response()->json(['error' => 'As partidas devem ser dobradas!'], 400);
            }

            // Verificar se as descricoes foram informadas
            if (strlen($transaction->description) < 3) {
                return response()->json(['error' => 'Preencha todos campos Descrição!'], 400);
            }

            $last_entry = DB::table('transactions_accounts')->whereNull('deleted_at')->where('account_id', $account->id)->latest('created_at')->first();

            $condition = false;

            if ($last_entry !== null) {
                $c_last_transaction_date = new DateTime($last_entry->created_at);
                $request_date = new DateTime($request->created_at);
                if ($c_last_transaction_date > $request_date) {
                    $condition = true;
                }
            }

            if ($condition == true) {
                Util::accountTransactionsSync('transactions_accounts', 'account_id', $account->id, 1);
            }
        }

        $transanction_lines_columns = array_column($transanction_lines, 'account');
        if ($transanction_lines_columns != array_unique($transanction_lines_columns)) {
            return response()->json(['error' => 'Conta(s) repetida(s)'], 400);
        }

        $total_debit = array_reduce($transanction_lines, function ($acomulator, $item) {
            $item = (object) $item;
            return floatval($acomulator) + $item->debit;
        }, 0);

        $total_credit = array_reduce($transanction_lines, function ($acomulator, $item) {
            $item = (object) $item;
            return floatval($acomulator) + $item->credit;
        }, 0);

        if ($total_debit != $total_credit) {
            return response()->json(['error' => 'As partidas devem ser dobradas!'], 400);
        }
    }

    public static function checkIfIsUnique($ref, $journal)
    {

        $journal = Journal::where('ref', $ref)
            ->where('journal_type_id', $journal)
            ->first();


        return $journal == null;
    }

    public static function invoiceNumber($date, $journal_type_id)
    {
        $year_and_month = explode('-', $date)[0] . '-' . explode('-', $date)[1];
        $total_records = DB::table('journals')
            ->whereNull('deleted_at')
            ->where('journal_type_id', $journal_type_id)
            ->where('journals.created_at', 'like', '%' . $year_and_month . '%')
            ->count('*');

        $ref = explode('-', $date)[0] . '' . explode('-', $date)[1] . '' . str_pad($total_records + 1, 4, '0', STR_PAD_LEFT);

        return $ref;
    }
}