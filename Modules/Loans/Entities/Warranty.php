<?php

namespace Modules\Loans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'code', 'value', 'created_by', 'acquisition_date', 'cost', 'loan_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Loans\Database\factories\WarrantyFactory::new();
    }

    protected static function boot()
    {
        parent::boot();
        Warranty::saved(function ($model) {
            Warranty::where('id', $model->id)->update(['code' => 'GARAN'.str_pad($model->id, 5, '0', STR_PAD_LEFT)]);
        });
    }
}
