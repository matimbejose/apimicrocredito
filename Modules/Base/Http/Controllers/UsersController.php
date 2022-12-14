<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // to access the authorize method

use Illuminate\Contracts\Support\Renderable;

use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Base\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Requests\CreateUserRequest;
use Modules\Base\Http\Requests\UpdateUserRequest;
use Spatie\Multitenancy\Models\Tenant;

class UsersController extends Controller
{
    use AuthorizesRequests; // to access the authorize method

    public $successStatus = 200;
    /**
     * Handles user logins
     *
     * @return void
     */
    public function index()
    {
        $this->authorize('view', User::class);
        return response()->json(['users' => User::where('type', '!=', 'sa')->with('roles')->get()]);
    }


    public function login()
    {
        if (auth()->attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = auth()->user();
            $user_roles = $user->roles;
            $permissions = [];
            foreach ($user_roles as $role) {
                $permissions[] = $role->name;
                $perms = $role->permissions;
                foreach ($perms as $p) {
                    $permissions[] = $p->name;
                }
            }

            $success['token'] =  auth()->user()->createToken('ttmGest')->accessToken;

            $success['business_id'] = base64_encode($user->businesses[0]->id);
            $success['authorities'] = $permissions;

            return response()->json(
                [
                    'success' => $success
                ],
                $this->successStatus
            );
        } else {
            return response()->json(['error' => 'Utilizador não encontrado.'], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);

        $input = request()->only([
            'first_name',
            'surname',
            'last_name',
            'address',
            'city',
            'username',
            'email',
            'password',
        ]);

        $input['type'] = !empty($request->type) ? $request->type : 'user';

        $input['gender'] = !empty($request->gender) ? $request->gender : null;
        $input['name'] = implode(' ', [$input['gender'] == 'M' ? 'Sr.' : 'Sra.', $input['first_name'], $input['last_name'], $input['surname']]);
        $input['phone'] = !empty($request->phone) ? preg_replace('/[^0-9]/', '', $request->phone) : null;

        if ($input['type'] === 'manager') {
            $existing_usernames = User::where('first_name', strtolower($input['first_name']))->count();
            if ($existing_usernames > 0) {
                $input['username'] = strtolower($input['first_name']) . $existing_usernames + 1;
            } else {
                $input['username'] = strtolower($input['first_name']);
            }
        }
        DB::beginTransaction();
        try {
            User::registeUser($input, ['roles' => $request->roles, 'businesses' => $request->businesses]);

            DB::commit();
            return response()->json(['success' => 'Criado com sucesso.'], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e->getMessage(), 500);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->authorize('update', User::class);
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(['errors' => $request->validator->messages()], 400);
        }

        $success = User::updateUser($request, $id);

        return response()->json(['success' => $success], $this->successStatus);
    }


    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function show($id)
    {
        return response()->json(['user' => User::find($id)], $this->successStatus);
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function notlogged()
    {
        return response()->json(['error' => 'You have no permission.'], 403);
    }

    /**
     * Handles user logins
     *
     * @return void
     */
    public function logout()
    {
        auth()->user()->token()->revoke();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->businesses()->detach();

        $user->delete();

        return response()->json(['success' => "Utilizador removido com sucesso."]);
    }
}