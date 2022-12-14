<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Modules\Base\Entities\Role;

use Modules\Business\Entities\Business;

use Laravel\Passport\HasApiTokens;

use DB;
use Exception;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $connection = 'tenant';

    protected $fillable = [
        'first_name',
        'surname',
        'last_name',
        'phone',
        'address',
        'ref_code',
        'city',
        'name',
        'username',
        'type',
        'gender',
        'roles',
        'email',
        'password',
        'businesses'
    ];


    protected static function newFactory()
    {
        return \Modules\Base\Database\factories\UserFactory::new();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

    public function assignRole(Role $role)
    {
        return $this->roles()->attach($role->id);
    }


    public function assignBusiness(Business $business)
    {
        return $this->businesses()->attach($business->id);
    }



    // public function hasRole($role)
    // {
    //     if (is_string($role)) {
    //         return $this->roles->contains('name', $role);
    //     }
    //     return !! $role->intersect($this->roles)->count();
    // }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission $permission
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }

    public function hasUser($user)
    {
        if (is_string($user)) {
            return $this->users->contains('name', $user);
        }
        return !!$user->intersect($this->users)->count();
    }

    public function hasBusiness($user)
    {
        $businesses = User::whereHas('businesses', function ($query) {
            $query->where('business_name', 'TTMInc');
        })->get();

        //return $businesses->contains('name', $user->name);
        return true;
    }

    public static function registeUser($request,  $business_and_roles)
    {
        $request['password'] = bcrypt($request['password']);


        $user = User::create($request);

        $users = User::find($user->id);


        if (isset($request['customer_user']) && $request['customer_user'] == true) {
            $customer = Role::where('name', 'Cliente')->first();

            # assign customer role
            $users->assignRole(Role::find($customer->id));

            # assign Business
            $users->assignBusiness(Business::find($business_and_roles['business_id']));
        }

        for ($i = 0; $i < count($business_and_roles['businesses']); $i++) {
            $users->assignBusiness(Business::find($business_and_roles['businesses'][$i]));
        }

        for ($i = 0; $i < count($business_and_roles['roles']); $i++) {
            $users->assignRole(Role::find($business_and_roles['roles'][$i]));
        }
    }

    public static function updateUser($request, $id)
    {
        $password = isset($request->password) ? bcrypt($request->password) : null;
        DB::beginTransaction();
        $user = User::where('id', $id)->update([
            'username' => $request->username,
            'last_name' => $request->last_name,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'email' => $request->email,
        ]);

        if ($password != null) {
            $user = User::where('id', $id)->update([
                'password' => $password
            ]);
        }

        $users = User::find($id);

        if (!empty($request->roles)) {
            for ($i = 0; $i < count($request->roles); $i++) {
                $users->roles()->sync([$id, $request->roles[$i]]);
            }
        }

        if (!empty($request->businesses)) {
            for ($i = 0; $i < count($request->businesses); $i++) {
                $users->businesses()->sync([$id, $request->businesses[$i]]);
            }
        }


        DB::commit();

        return 'Utilizador actualizado com sucesso.';
    }

    protected static function boot()
    {
        parent::boot();
        User::saved(function ($model) {
            User::where('id', $model->id)->update(['ref_code' => 'USR' . str_pad($model->id, 4, '0', STR_PAD_LEFT)]);
        });
    }
}
