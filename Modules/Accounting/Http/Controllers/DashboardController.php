<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountClosing;
use Modules\Accounting\Entities\AccountTransaction;
use Modules\Accounting\Utils\Util;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = [];
        for ($i = 1; $i < 9; $i++) {
            $total_class = 0;
            $prev_total_class = 0;
            $processed_class = [];
            $classData = Account::where('class_id', $i)->where('parent_id', null)->select('uuid', 'id', 'balance', 'type')->get();
            $last_transaction_date = AccountTransaction::select('created_at')->latest('created_at')->first();
            $acc_closings = AccountClosing::select('year')->latest('id')->first();

            foreach ($classData as $value) {
                $prev_mother_acc = 0;
                $sub_prev_class_total = 0;
                if ($acc_closings == null) {
                    $sub_class_subs = Account::where('master_parent_id', $value->uuid)->select('id', 'uuid', 'type', 'balance as total', 'name')->orderBy('uuid')->get();
                } else {
                    $sub_class_subs = Account::where('accounts.master_parent_id', $value->uuid)
                        ->join('account_closings', function ($join) use ($acc_closings) {
                            $join->on('account_closings.account_id', '=', 'accounts.id')
                                ->where('account_closings.year', '=', $acc_closings->year);
                        })
                        ->select(
                            'accounts.id',
                            'accounts.uuid',
                            'accounts.balance',
                            'accounts.type',
                            'accounts.name',
                            'account_closings.balance as prev_balance'
                        )
                        ->orderBy('accounts.uuid')
                        ->get();

                    foreach ($sub_class_subs as $item) {
                        $sub_prev_class_total += $item->prev_balance;
                    }

                    $prev_mother_acc = AccountClosing::where('account_id', $value->id)->select('balance')->first();
                    $prev_mother_acc = $prev_mother_acc != null ? $prev_mother_acc->balance : 0;
                }
                $sub_class_name = Account::where('uuid', $value->uuid)->select('name', 'uuid')->first();
                $sub_class_total = Account::where('master_parent_id', $value->uuid)->sum('balance');
                $total = floatval($sub_class_total) + floatval($value->balance);
                $tmp['type'] = $value->type;
                $tmp['name'] = join('', explode('.', $value->uuid)) . ' - ' . $sub_class_name->name;
                $tmp['total'] = $total;
                $tmp['key'] = $value->uuid;
                $tmp['prev_total'] = floatval($sub_prev_class_total) + floatval($prev_mother_acc);
                $tmp['accounts'] = $sub_class_subs;

                $total_class += $total;
                $prev_total_class += $sub_prev_class_total;
                if ($total > 0 || $total < 0) {
                    array_push($processed_class, $tmp);
                }
            }


            $data['class_' . $i] = [
                'total' => $total_class,
                'prev_total' => $prev_total_class,
                'data' => $processed_class,

            ];
        }
        $data['class_4_actives'] = Util::dashboardClassAciveOrPassive('active', 4);
        $data['class_4_passives'] = Util::dashboardClassAciveOrPassive('passive', 4);
        $data['class_3_actives'] = Util::dashboardClassAciveOrPassive('active', 3);
        $data['class_3_passives'] = Util::dashboardClassAciveOrPassive('passive', 3);

        $data['dates'] = [
            'from' => $acc_closings != null ? $acc_closings->year : '-',
            'to' => $last_transaction_date != null ? explode('-', $last_transaction_date->created_at)[0] : '-'
        ];
        //     dd($data);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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