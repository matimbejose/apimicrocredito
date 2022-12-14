<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Gate;

use Modules\Business\Entities\Account;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Modules\Business\Http\Requests\CreateAccountRequest;
use Modules\Business\Http\Requests\UpdateAccountRequest;

use Auth;

class AccountController extends Controller
{
    use AuthorizesRequests;
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('view', Account::class);
        return response()->json(['accounts' => Account::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAccountRequest $request)
    {
        //$this->authorize('create', Account::class);

        try {

            $account = Account::create([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'type' => $request->type,
                'other_details' => ucfirst($request->other_details),
            ]);

            return response()->json(['success'=>'Adicionado com sucesso!'], $this->successStatus);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $this->authorize('view', Account::class);
        return response()->json(Account::first($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, $id)
    {
        $this->authorize('update', Account::class);

        try {

            $account = Account::find($id)->update([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'type' => $request->type,
                'other_details' => ucfirst($request->other_details),
            ]);

            return response()->json(['success'=>'Actualizado com sucesso!'], $this->successStatus);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return response($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        $credit_type = CreditType::where('id', $id)->firstOrFail();
        $loan = Loan::where('credit_type', $id)->first();
        if ($loan != null) {
            return response()->json(['error'=>'Garantia em uso!'], 400);
        }
        if($credit_type->trashed()) {
            $credit_type->forceDelete();                                               
        } else {
            $credit_type->delete();
        }
        return response()->json(['success'=>'Movida para lata de lixo!']);
    }
    /**
     * display a list of all trashed posts.
     *
     *
     * 
     */
    public function trashed()
    {
        $trashed = Account::onlyTrashed()->get();
        return response()->json(Account::withCategories($trashed));
    }
    public function restore($id)
    {
        $account = Account::withTrashed()->where('id', $id)->firstOrFail();
        session()->flush('success', 'Restaurado com sucesso!');
        $account->restore();
    }
}
