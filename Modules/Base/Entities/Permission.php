<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Base\Entities\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_to_show',
        'guard_name',
        'model_name'
    ];

    protected $guarded = ['id'];

    protected $table = 'permissions';

    
    protected static function newFactory()
    {
        return \Modules\Base\Database\factories\PermissionFactory::new();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
    /**
     * Determine if the permission belongs to the role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function inRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }
}
