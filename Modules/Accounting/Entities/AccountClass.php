<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id'];
    
    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\AccountClassFactory::new();
    }
}
