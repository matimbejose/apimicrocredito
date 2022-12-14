<?php

namespace Modules\Managers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Managers\Entities\Manager;
use Modules\Business\Entities\Business;

use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'managers';
       /**
     *|------------------------------------------------------------------------------------------------
     *| Ralationships
     *|------------------------------------------------------------------------------------------------
     *|
     */

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'phone',
        'address',
        'city',
        'gender',
        'business_id',
        'created_by'

    ];

    public function businesses() {
        return $this->belongsToMany(Business::class);
    }

    /**
     *|------------------------------------------------------------------------------------------------
     *| General functions
     *|------------------------------------------------------------------------------------------------
     *|
     */

    public static function saveManager($input) 
    {
        $manager = Manager::create($input);
        
    }

    public static function updateManager($input, $id) 
    {
        Manager::find($id)->update($input);
        
    }

    protected static function boot()
    {
        parent::boot();
        Manager::saved(function ($model) {
            Manager::where('id', $model->id)->update(['ref_code' => 'GES'.str_pad($model->id, 4, '0', STR_PAD_LEFT)]);
        });
    }

    
    protected static function newFactory()
    {
        return \Modules\Managers\Database\factories\ManagerFactory::new();
    }
}
