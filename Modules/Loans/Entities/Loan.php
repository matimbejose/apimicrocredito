<?php

namespace Modules\Loans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Base\Entities\User;
use Modules\Customers\Entities\Customer;
use Modules\Loans\Entities\CreditType;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return \Modules\Loans\Database\factories\LoanFactory::new();
    }

    /**
     * Get the post that owns the comment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function loan_transactions()
    {
        return $this->hasMany('Modules\Loans\Entities\LoanTransaction');
    }

    /**
     * Get the post that owns the comment.
     */
    public function loan_schedules()
    {
        return $this->hasMany('Modules\Loans\Entities\LoanSchedule');
    }

    /**
     * Get the post that owns the comment.
     */
    public function credit_type()
    {
        return $this->belongsTo('Modules\Loans\Entities\CreditType');
    }

    /**
     * The roles that belong to the user.
     */
    public function warranties()
    {
        return $this->belongsToMany('Modules\Loans\Entities\Warranty');
    }

    protected static function boot()
    {
        parent::boot();
        Loan::saved(function ($model) {
            Loan::where('id', $model->id)->update(['code' => 'EMP' . str_pad($model->id, 5, '0', STR_PAD_LEFT)]);
        });
    }

    /**
     * The roles that belong to the user.
     */
    public static function totalFees($request)
    {
        $anual_tax = CreditType::find($request->credit_type)->tax;
        $anual_tax_decimal = $anual_tax / 100;

        $fees = floatval($request->amount) * (floatval($anual_tax_decimal) / 12);

        return $fees * $request->maturity;
    }
}
