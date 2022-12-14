<?php

namespace Modules\Loans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'credit_types';

    protected $fillable = ['name', 'description', 'code', 'tax', 'type', 'value', 'created_by'];

    protected static function newFactory()
    {
        return \Modules\Loans\Database\factories\CreditTypeFactory::new();
    }

    /**
     * Get the loans for the blog customer.
     */
    public function loans()
    {
        return $this->hasMany('App\Loan');
    }

    protected static function boot()
    {
        parent::boot();
        CreditType::saved(function ($model) {
            CreditType::where('id', $model->id)->update(['code' => 'CT' . str_pad($model->id, 4, '0', STR_PAD_LEFT)]);
        });
    }
}