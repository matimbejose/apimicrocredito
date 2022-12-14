<?php

namespace Modules\Business\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'content', 'created_by'];

    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\DocumentFactory::new();
    }
}
