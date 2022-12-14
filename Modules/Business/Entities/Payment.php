<?php

namespace Modules\Business\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\PaymentFactory::new();
    }

    /**
     * Get the post that owns the comment.
     */
    public function customer()
    {
        return $this->belongsTo('Modules\Customers\Entities\Customer');
    }

    protected static function boot()
    {
        parent::boot();
        Payment::saved(function ($model) {
            Payment::where('id', $model->id)->update(['code' => 'REC' . str_pad($model->id, 4, '0', STR_PAD_LEFT)]);
        });
    }
}