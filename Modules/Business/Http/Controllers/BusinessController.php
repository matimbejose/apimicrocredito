<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Business\Entities\Business;
use Modules\Business\Entities\DefaultPrice;
use Modules\Business\Http\Requests\UpdateBusinessRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;


use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BusinessController extends Controller
{
    use AuthorizesRequests;
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('view', Business::class);
        return response()->json(['businesses' => Business::first()]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function listBusinessesVueFormMultiselect()
    {
        $this->authorize('view', Business::class);
        $businesses = Business::select('id', 'business_name')->get();
        $business_array = [];
        foreach ($businesses as $business) {
            $tmp_business['value'] = $business->id;
            $tmp_business['label'] = $business->business_name;

            array_push($business_array, $tmp_business);
        }

        return response()->json(['businesses' => $business_array]);
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
        dd($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return response()->json(['business' => Business::find($id)]);
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
    public function update(UpdateBusinessRequest $request, $id)
    {
        $imageName = null;
        if (is_file($request->logo)) {
            $imageName = time() . '.' . $request->logo->getClientOriginalExtension();
            $image       = $request->file('logo');

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(110, 110);
            $image_resize->save(public_path('img/' . $imageName));
        }
        //$this->authorize('update', Business::class);



        try {
            $input = $request->only([
                'business_name',
                'start_date',
                'logo',
                'address',
                'business_id',
                'nuit',
                'phone',
                'billing_type',
                'charges_fee',
                'acc_clients',
                'acc_charges',
                'acc_increases',
                'acc_advances',
                'acc_finantial_looses',
                'acc_finantial_incomes',
            ]);

            $input['created_by'] = auth('api')->user()->id;
            $input['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);
            $input['nuit'] = preg_replace('/[^0-9]/', '', $input['nuit']);
            $input['logo'] = $imageName ? $imageName : null;

            Business::updateBusiness($input, $id);

            return response()->json(['success' => 'Actualizado com sucesso.']);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e->getMessage(), 500);
        }
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update_rules(Request $request)
    {
        // $this->validate($request, [
        //     'billing_type' => 'required',
        //     'charges_fee' => 'required',
        //     'acc_clients' => 'required',
        //     'acc_charges' => 'required',
        //     'acc_advances' => 'required',
        //     'acc_increases' => 'required',
        //     'acc_finantial_looses' => 'required',
        //     'acc_finantial_incomes' => 'required',
        // ]);
        dd($request->charges_fee);

        try {
            $input = $request->only([
                'billing_type',
                'charges_fee',
                'acc_clients',
                'acc_charges',
                'acc_increases',
                'acc_advances',
                'acc_finantial_looses',
                'acc_finantial_incomes',
            ]);

            Business::updateBusiness($input, $request->id);

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
        //
    }
}