<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Business\Entities\Business;
use Modules\Business\Entities\Document;
use Modules\Loans\Entities\CreditType;

class DocumentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('view', Business::class);
        return response()->json(['documents' => Document::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('business::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('create', Business::class);

        if (empty($request->description) || empty($request->content)) {
            return response()->json(['error' => 'Verifique os dados e tente novamente.'], 400);
        }

        try {
            DB::beginTransaction();
            Document::create([
                'created_by' => Auth::id(),
                'description' => $request->description,
                'content' => $request->content,
            ]);

            DB::commit();
            return response()->json(['success' => 'Criado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
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
        $this->authorize('view', Business::class);
        return response()->json(Document::select('id', 'content', 'description')->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('business::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', CreditType::class);

        try {

            Document::find($id)->update([
                'created_by' => Auth::id(),
                'description' => $request->description,
                'content' => $request->content,
            ]);

            return response()->json(['success' => 'Actualizado com sucesso!'], 200);
        } catch (\Exception $e) {
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
        //
    }
}
