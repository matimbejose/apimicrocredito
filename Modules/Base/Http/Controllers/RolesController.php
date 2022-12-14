<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Entities\Role;
use Modules\Base\Entities\Permission;

use Modules\Base\Entities\User;

use DB;
use Session;

use Modules\Business\Entities\Business;

use Modules\Base\Http\Requests\CreateRoleRequest;
use Modules\Base\Http\Requests\UpdateRoleRequest;

class RolesController extends Controller
{
    use AuthorizesRequests;
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //dd(User::find(1)->hasBusiness('TTMIgnc'));
        $this->authorize('view', Role::class);

        return response()->json(['roles' => Role::where('name', '!=', 'SA')->with('permissions')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function listRolesVueFormMultiselect()
    {
        $this->authorize('view', Role::class);

        $roles = Role::where('name', '!=', 'SA')->select('id', 'name')->get();
        $roles_array = [];
        foreach ($roles as $role) {
            $tmp_role['value'] = $role->id;
            $tmp_role['label'] = $role->name;

            array_push($roles_array, $tmp_role);
        }

        return response()->json(['roles' => $roles_array]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function permissions()
    {
        return response()->json(['permissions' => DB::table('permissions')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        DB::beginTransaction();
        $role = Role::create(['name' => $request->name]);

        foreach ($request->permissions as $permission) {
            $role = Role::find($role->id);
            $role->assignPermission(Permission::find($permission));
        }
        DB::commit();

        return response()->json(['success' => 'Cargo criado com sucesso!'], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('view', Role::class);
        $role = Role::find($id);


        return response()->json(['role' => Role::find($id), 'permissions' => $role->permissions], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $this->authorize('update', Role::class);
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(['errors' => $request->validator->messages()], 400);
        }

        $success = Role::updateRole($request, $id);

        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('delete', Role::class);
        $role = Role::find($id);
        if (count($role->users) > 0) {
            return response()->json(['error' => 'Cargo em uso.'], 400);
        }
        $role->permissions()->detach();

        $role->delete();

        return response()->json(['success' => "Utilizador removido com sucesso."]);
    }
}