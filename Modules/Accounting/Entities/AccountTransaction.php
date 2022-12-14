<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'amount', 'initial_amount', 
        'final_amount','notes', 'account_id', 'type', 
        'created_at', 'description', 'operation',
        'invoice_id', 'transaction_id', 'journal_id', 'journal_type_id', 'cost_center_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\AccountTransactionFactory::new();
    }
}
