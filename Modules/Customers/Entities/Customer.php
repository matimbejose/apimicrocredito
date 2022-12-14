<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounting\Entities\Account;
use Modules\Business\Entities\Business;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'doc_type',
        'phone',
        'alternative_phone',
        'family_phone',
        'type',
        'doc_nr',
        'nuit',
        'address',
        'nationality',
        'city',
        'house_nr',
        'credit_limit',
        'balance',
        'gender',
        'quarter',
        'debit',
        'credit',
        'residence',
        'activity',
        'birthdate',
        'emission_date',
        'expiration_date',
        'business_id',
        'created_by',
        'account_id'

    ];



    protected static function newFactory()
    {
        return \Modules\Customers\Database\factories\CustomerFactory::new();
    }
    /**
     *|------------------------------------------------------------------------------------------------
     *| Ralationships
     *|------------------------------------------------------------------------------------------------
     *|
     */

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     *|------------------------------------------------------------------------------------------------
     *| General functions
     *|------------------------------------------------------------------------------------------------
     *|
     */

    public static function saveCustomer($input)
    {
        # Check if the DOC_ID is already in use
        $doc_id = null;
        if (!empty($input['doc_id'])) {
            $doc_id = Customer::where('business_id', $input['business_id'])
                ->where('doc_id', $input['doc_id'])
                ->first();
        }

        if ($doc_id == null) {

            $customer = Customer::create($input);
        } else {
            throw new \Exception("O documento esta em uso.", 1);
        }
    }

    public static function updateCustomer($input, $id)
    {
        # Check if the DOC_ID is already in use
        Customer::find($id)->update($input);
    }

    public static function increaseBalance(int $id, float $amount): void
    {
        $customer = Customer::findOrFail($id);

        $customer->increment('balance', $amount);
    }

    public static function decreaseBalance(int $id, float $amount): void
    {
        $customer = Customer::findOrFail($id);

        $customer->decrement('balance', $amount);
    }


    protected static function boot()
    {
        parent::boot();
        Customer::saved(function ($model) {
            Customer::where('id', $model->id)->update(['ref_code' => 'CLI' . str_pad($model->id, 4, '0', STR_PAD_LEFT)]);
        });
    }
}
