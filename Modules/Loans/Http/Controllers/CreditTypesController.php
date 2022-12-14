<?php

namespace Modules\Loans\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Gate;

use Modules\Loans\Entities\CreditType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Modules\Loans\Http\Requests\CreateCreditTypeRequest;
use Modules\Loans\Http\Requests\UpdateCreditTypeRequest;

use Auth;
use Illuminate\Support\Facades\DB;

class CreditTypesController extends Controller
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
        $this->authorize('view', CreditType::class);
        return response()->json(['credit_types' => CreditType::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCreditTypeRequest $request)
    {
        $this->authorize('create', CreditType::class);

        if ($request->type == 'monthly' && intval($request->value) > 30) {
            return response()->json(['error' => 'Verifique os dados e tente novamente.']);
        }
        if ($request->type == 'yearly' && intval($request->value) > 12) {
            return response()->json(['error' => 'Verifique os dados e tente novamente.']);
        }

        try {
            DB::beginTransaction();
            CreditType::create([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'tax' => $request->tax,
                'value' => $request->value,
                'type' => $request->type
            ]);

            DB::commit();
            return response()->json(['success' => 'Criado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
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
        $this->authorize('view', CreditType::class);
        return response()->json(CreditType::select('id', 'name', 'description', 'tax', 'business_id')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCreditTypeRequest $request, $id)
    {
        $this->authorize('update', CreditType::class);

        try {

            $creditType = CreditType::find($id)->update([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'tax' => $request->tax,
                'value' => $request->value,
                'type' => $request->type
            ]);

            return response()->json(['success' => 'Actualizado com sucesso!'], $this->successStatus);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        $credit_type = CreditType::where('id', $id)->firstOrFail();
        $loan = Loan::where('credit_type', $id)->first();
        if ($loan != null) {
            return response()->json(['error' => 'Garantia em uso!'], 400);
        }
        if ($credit_type->trashed()) {
            $credit_type->forceDelete();
        } else {
            $credit_type->delete();
        }
        return response()->json(['success' => 'Movida para lata de lixo!']);
    }
    /**
     * display a list of all trashed posts.
     *
     *
     * 
     */
    public function trashed()
    {
        $trashed = CreditType::onlyTrashed()->get();
        return response()->json(CreditType::withCategories($trashed));
    }
    public function restore($id)
    {
        $creditType = CreditType::withTrashed()->where('id', $id)->firstOrFail();
        session()->flush('success', 'Restaurado com sucesso!');
        $creditType->restore();
    }
}