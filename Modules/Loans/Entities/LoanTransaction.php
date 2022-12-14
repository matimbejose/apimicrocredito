<?php

namespace Modules\Loans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Auth;
use Carbon\Carbon;
use Modules\Loans\Entities\CreditType;

class LoanTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'scheduled_date',
        'effective_date',
        'effective_payment',
        'initial_balance',
        'scheduled_payment',
        'fees', 'divers_id',
        'delay_fees',
        'main_capital',
        'final_balance',
        'loan_id',
        'created_by',
        'disbursed_amount',

    ];

    protected static function newFactory()
    {
        return \Modules\Loans\Database\factories\LoanTransactionFactory::new();
    }

    /**
     * Get the post that owns the comment.
     */
    public function loan()
    {
        return $this->belongsTo('Modules\Loans\Entities\Loan');
    }

    /**
     * Get the post that owns the comment.
     */
    public function loan_schedule()
    {
        return $this->belongsTo('Modules\Loans\Entities\LoanSchedule');
    }

    protected static function boot()
    {
        parent::boot();
        LoanTransaction::saved(function ($model) {
            LoanTransaction::where('id', $model->id)->update(['code' => 'PGT' . str_pad($model->id, 5, '0', STR_PAD_LEFT)]);
        });
    }

    protected static function transactionData($request)
    {
        $loan_id = Loan::where('customer_id', $request->customer_id)->where('status', 'disbursed')->select('id')->first();
        $loan = Loan::find($loan_id->id);
        if ($loan->status != 'disbursed') {
            return response()->json(['error' => 'Operacao recusada!'], 500);
        }
        # BEGIN MATHS OPERATIONS

        $input = [];

        $today = Carbon::now('Africa/Maputo');
        $anual_tax = CreditType::find($loan->credit_type)->tax;
        $anual_tax_decimal = $anual_tax / 100;
        $initial_balance = 0;
        $final_balance = 0;

        $last_payment = LoanTransaction::select('effective_date', 'final_balance')->latest('effective_date')->first();

        if ($last_payment != null) {
            $input['scheduled_date'] = Carbon::create($last_payment->effective_date)->addMonth();
            $input['initial_balance'] = $last_payment->final_balance;
        } else {
            $input['scheduled_date'] = Carbon::create($loan->disbursed_at)->addMonth();
            $input['initial_balance'] = $loan->disbursed_amount;
        }
        $input['scheduled_payment'] =
            floatval($loan->disbursed_amount) * ((floatval($anual_tax_decimal) / 12) / (1 - pow(1 + ($anual_tax_decimal / 12), -floatval($loan->maturity))));

        $input['effective_payment'] = $request->effective_payment;

        $input['fees'] = floatval($input['initial_balance']) * (floatval($anual_tax_decimal) / 12);

        $input['main_capital'] = floatval($input['scheduled_payment']) - floatval($input['fees']);
        $input['final_balance'] = floatval($input['initial_balance']) - floatval($input['main_capital']);
        $input['description'] = $request->description;
        $input['effective_date'] = $request->created_at;

        # (effective_date - scheduled_date) * $loan->monthly_installment/30*(scheduled_payment-fees)
        $dt1 = Carbon::create($request->created_at);
        $dt2 = Carbon::parse($input['scheduled_date']);
        $delayed_period = $dt1->diffInDays($dt2);
        if ($dt1->greaterThan($dt2) || $request->effective_payment < $input['scheduled_payment']) {
            $input['delay_fees'] = $delayed_period * $loan->monthly_installment / 30 * ($input['scheduled_payment'] - $input['fees']);
        } else {
            $input['delay_fees'] = 0;
        }

        $input['loan_id'] = $request->loan;
        $input['created_by'] = auth('api')->user()->id;

        return $input; # 0 / 30 * 20
    }
}