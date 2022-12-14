<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Base\Entities\Permission;
use Modules\Base\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name'
    ];
    protected $guarded = ['id'];
    protected $table = 'roles';
    private $name;
    private $guard_name;



    protected static function newFactory()
    {
        return \Modules\Base\Database\factories\RoleFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
    public function assignPermission(Permission $permission)
    {
        return $this->permissions()->attach($permission->id);
    }
    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission, User $user)
    {
        return $this->hasRole($permission->roles);
    }
    /**
     * Determine if the role has the given permission.
     *
     * @param  mixed $permission
     * @return boolean
     */
    public function inRole($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        return !!$permission->intersect($this->permissions)->count();
    }

    public static function updateRole($request, $id)
    {
        DB::beginTransaction();
        $role = Role::find($id)->update([
            'name' => $request->name,
        ]);

        $roles = Role::find($id);
        $ids = array_values($request->permissions);

        $roles->permissions()->sync($ids);

        // if (!empty($request->permissions)) {
        //     foreach ($request->permissions as $permission) {
        //         $roles->assignPermission(Permission::find($permission));
        //     }
        // }

        DB::commit();

        return 'Cargo actualizado com sucesso.';
    }
}