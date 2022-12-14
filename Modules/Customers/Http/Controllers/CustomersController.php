<?php

namespace Modules\Customers\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Customers\Entities\Customer;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Account;
use Modules\Business\Entities\Business;
use Modules\Customers\Http\Requests\CreateCustomerRequest;
use Modules\Customers\Http\Requests\UpdateCustomerRequest;

class CustomersController extends Controller
{

    use AuthorizesRequests;
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('view', Customer::class);
        return response()->json([
            'customers' => Customer::select('ref_code', 'id', 'name', 'address', 'phone')->get(),
            'total' => Customer::count('*')
        ]);
    }

    public function search_customers(Request $req)
    {
        $customers = [];
        $this->authorize('view', Customer::class);
        if ($req->has('q')) {
            $search = $req->q;
            $customers = Customer::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($customers);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCustomerRequest $request)
    {
        $this->authorize('create', Customer::class);
        DB::beginTransaction();
        try {
            $input = $request->only([
                'name',
                'last_name',
                'first_name',
                'middle_name',
                'email',
                'doc_type',
                'phone',
                'alternative_phone',
                'family_phone',
                'doc_nr',
                'address',
                'country',
                'city',
                'birthdate',
                'emission_date',
                'expiration_date',
                'residence',
                'activity',
                'nationality',
                'house_nr',
                'type',
                'balance',
                'debit',
                'credit',
                'business_id',
                'gender',
                'nuit'
            ]);

            $input['name'] = $request->name == '' ? implode(' ', [$input['gender'] == 'M' ? 'Sr.' : 'Sra.', $input['first_name'], $input['middle_name'], $input['last_name']]) : $request->name;
            $input['business_id'] = base64_decode($input['business_id']);
            $input['created_by'] = auth('api')->user()->id;
            $input['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);
            $input['alternative_phone'] = !empty($input['alternative_phone']) ? preg_replace('/[^0-9]/', '', $input['alternative_phone']) : null;
            $input['family_phone'] = !empty($input['family_phone']) ? preg_replace('/[^0-9]/', '', $input['family_phone']) : null;

            $business = Business::firstOrFail();

            $check_children = Account::where('parent_id', $business->acc_clients)->whereNull('deleted_at')->latest('id')->first();
            $uuid = $business->acc_clients . '.0.0.0.1';
            if ($check_children !== null) {
                $previews_uuid = str_replace('.', '', $check_children->uuid);
                $uuid = $previews_uuid + 1;
            }

            $account = Account::create([
                'created_by' => FacadesAuth::id(),
                'name' => ucfirst($input['name']),
                'balance' => 0,
                'initial_balance' => 0,
                'notes' => $input['name'],
                'account_number' => '',
                'type' => 'active',
                'balance' => 0,
                'initial_balance' => 0,
                'uuid' => $uuid,
                'class_id' => 4,
                'parent_id' => '4.1.1',
                'master_parent_id' => '4.1',
            ]);

            $input['account_id'] = $account->id;

            Customer::saveCustomer($input);


            // if ($request->create_user) {
            //     $user_request = (Object) [
            //         'username' => $request->username,
            //         'last_name' => $request->middle_name,
            //         'surname' => $request->last_name,
            //         'first_name'=>$request->first_name,
            //         'email'=>$request->email,
            //         'password'=>$password,
            //         'customer_user' => true
            //     ];
            //     User::registeUser($user_request);
            // }
            DB::commit();
            return response()->json(['success' => 'Criado com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('view', Customer::class);
        return response()->json(['customer' => Customer::find($id)], $this->successStatus);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $this->authorize('update', Customer::class);
        try {
            $input = $request->only([
                'name',
                'last_name',
                'first_name',
                'middle_name',
                'email',
                'doc_type',
                'phone',
                'alternative_phone',
                'family_phone',
                'doc_nr',
                'address',
                'country',
                'city',
                'quarter',
                'birthdate',
                'emission_date',
                'expiration_date',
                'residence',
                'activity',
                'nationality',
                'house_nr',
                'type',
                'balance',
                'debit',
                'credit',
                'business_id',
                'gender',
                'nuit'
            ]);

            $input['name'] = $request->name == '' ? implode(' ', [$input['gender'] == 'M' ? 'Sr.' : 'Sra.', $input['first_name'], $input['middle_name'], $input['last_name']]) : $request->name;
            $input['business_id'] = $request->business_id;
            $input['created_by'] = auth('api')->user()->id;
            $input['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);
            $input['nuit'] = preg_replace('/[^0-9]/', '', $input['nuit']);
            $input['alternative_phone'] = preg_replace('/[^0-9]/', '', $input['alternative_phone']);
            $input['family_phone'] = preg_replace('/[^0-9]/', '', $input['family_phone']);

            Customer::updateCustomer($input, $id);

            // if ($request->create_user) {
            //     $user_request = (Object) [
            //         'username' => $request->username,
            //         'last_name' => $request->middle_name,
            //         'surname' => $request->last_name,
            //         'first_name'=>$request->first_name,
            //         'email'=>$request->email,
            //         'password'=>$password,
            //         'customer_user' => true
            //     ];
            //     User::registeUser($user_request);
            // }

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
        $this->authorize('delete', Customer::class);
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json(['success' => "Cliente removido com sucesso."]);
    }
}