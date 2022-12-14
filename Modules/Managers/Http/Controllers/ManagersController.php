<?php

namespace Modules\Managers\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Managers\Entities\Manager;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use Modules\Base\Entities\User;
use Modules\Loans\Entities\Loan;
use Modules\Managers\Http\Requests\CreateManagerRequest;
use Modules\Managers\Http\Requests\UpdateManagerRequest;

class ManagersController extends Controller
{

    use AuthorizesRequests;
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('view', User::class);
        return response()->json(['users' => User::where('type', 'manager')->with('roles')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateManagerRequest $request)
    {
        $this->authorize('create', Manager::class);
        try {
            $input = $request->only([
                'name',
                'last_name',
                'first_name',
                'middle_name',
                'email',
                'phone',
                'address',
                'country',
                'city',
                'business_id',
                'gender',
                'nuit'
            ]);

            $input['name'] = $request->name == '' ? implode(' ', [$input['gender'] == 'M' ? 'Sr.' : 'Sra.', $input['first_name'], $input['middle_name'], $input['last_name']]) : $request->name;
            $input['business_id'] = base64_decode($input['business_id']);
            $input['created_by'] = auth('api')->user()->id;
            $input['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);

            Manager::saveManager($input);

            return response()->json(['success' => 'Criado com sucesso.']);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function loans($id)
    {
        $this->authorize('view', Loan::class);
        return response()->json([
            'loans' => Loan::where('user_id', $id)
                ->join('customers', 'customers.id', 'loans.customer_id')
                ->join('users', 'users.id', 'loans.user_id')
                ->with('loan_transactions')
                ->select(
                    'loans.*',
                    'customers.name as customer',
                    'users.name as manager',
                )
                ->get()
        ], $this->successStatus);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('view', Manager::class);
        return response()->json(['manager' => Manager::find($id)], $this->successStatus);
    }

    public function search_managers(Request $req)
    {
        $managers = [];
        $this->authorize('view', User::class);
        if ($req->has('q')) {
            $search = $req->q;
            $managers = User::where('type', 'manager')
                ->select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($managers);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateManagerRequest $request, $id)
    {
        $this->authorize('update', Manager::class);
        try {
            $input = $request->only([
                'name',
                'last_name',
                'first_name',
                'middle_name',
                'email',
                'phone',
                'address',
                'country',
                'city',
                'business_id',
                'gender',
                'nuit'
            ]);

            $input['name'] = $request->name == '' ? implode(' ', [$input['gender'] == 'M' ? 'Sr.' : 'Sra.', $input['first_name'], $input['middle_name'], $input['last_name']]) : $request->name;
            $input['business_id'] = $request->business_id;
            $input['created_by'] = auth('api')->user()->id;
            $input['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);

            Manager::updateManager($input, $id);


            return response()->json(['success' => 'Actualizado com sucesso.']);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        # Missing implementations, we will need to verify if the user has an related Transactions
        $this->authorize('delete', Manager::class);
        $manager = Manager::find($id);

        $manager->delete();

        return response()->json(['success' => "Removido com sucesso."]);
    }
}
