<?php

namespace Modules\Business\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Base\Entities\User;


class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'business_name',
        'start_date',
        'logo',
        'address',
        'nuit',
        'charges_fee',
        'phone',
        'billing_type',
        'acc_clients',
        'acc_advances',
        'acc_charges',
        'acc_increases',
        'acc_finantial_incomes',
        'acc_finantial_looses',
    ];

    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\BusinessFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function hasUser(User $user)
    {
        return $this->hasBusiness($permission->roles);
    }

    public static function updateBusiness($input, $id)
    {
        # Check if the DOC_ID is already in use
        Business::find($id)->update($input);
    }
}
