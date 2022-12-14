<?php

namespace Modules\Base\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Modules\Base\Entities\User;

use Modules\Base\Entities\Permission;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        $user = auth()->user();
        $user = User::find($user->id);

        $permission = Permission::where('name', 'user-view')->first();
        return $user->hasRole($permission->roles) && $user->hasBusiness($user);
    }
    /**
     * Determine whether the user can create items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user = auth()->user();
        $user = User::find($user->id);

        $permission = Permission::where('name', 'user-create')->first();
        return $user->hasRole($permission->roles) && $user->hasBusiness($user);
    }
    /**
     * Determine whether the user can update the item.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        $user = auth()->user();
        $user = User::find($user->id);

        $permission = Permission::where('name', 'user-edit')->first();
        return $user->hasRole($permission->roles) && $user->hasBusiness($user);
    }
    /**
     * Determine whether the user can delete the item.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        $permission = Permission::where('name', 'user-delete')->first();
        return $user->hasRole($permission->roles);
    }
}
