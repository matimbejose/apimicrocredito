<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Utils\Util;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\CostCenter;
use Modules\Accounting\Entities\JournalType;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $journal_types = JournalType::all();
        $cost_centers = CostCenter::all();

        $last_journal = Journal::select('created_at')->latest('id')->first();
        $last_date = date('Y-m-d');
        if ($last_journal != null) {
            $last_date = $last_journal->created_at;
        }


        // $journals = Journal::join(
        //     'journal_types',
        //     'journal_types.id',
        //     'journals.journal_type_id'
        // );

        // $search_value = request()->get('search');
        // if (!empty($search_value['value'])) {
        //     $search = $search_value['value'];
        //     $journals->where(function ($q) use ($search) {
        //         $q->where('ref', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
        //     });
        // }

        // $order = request()->get('order');
        // $order_by = 'ref';
        // $order_diration = 'asc';
        // if (!empty($order['column']) && $order['column'] != 0) {
        //     $order_by = $order['column'];
        //     $order_diration = $order['dir'];
        // }

        // $cost_center = request()->get('cost_center');
        // $journal_type = request()->get('journal_type');
        // if (!empty($cost_center)) {
        //     if ($cost_center != 'all') {
        //         $journals->where('journals.location_id', '=', $cost_center);
        //     }
        // }
        // if (!empty($journal_type)) {
        //     if ($journal_type != 'all') {
        //         $journals->where('journals.journal_type_id', '=', $journal_type);
        //     }
        // }

        // if (request()->ajax()) {
        //     $journals->whereDate('journals.created_at', '>=', request()->get('from'))
        //         ->whereDate('journals.created_at', '<=', request()->get('to'));
        // }

        //$journals = Journal::select('journals.*', 'journal_types.label', 'journal_types.uuid')
        // ->orderBy($order_by, $order_diration)
        $journals = Journal::paginate(!empty(request()->get('length')) ? request()->get('length') : 20);

        $journalList = [];
        foreach ($journals->items() as $item) {
            $new_items = [];
            //$new_items[] = '#';
            $new_items[] = $item->ref;
            $new_items[] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at, 'Africa/Maputo')->isoFormat('YYYY-MM-DD');
            //$new_items[] = $item->uuid . '' . $item->label;
            //$new_items[] = $item->description;
            $new_items[] = number_format(floatval($item->amount), 2);
            $new_items[] = '<div class="pull-right no-print">
                    <button id="view-' . $item->id . '" class="btn btn-info btn-xs" data-toggle="modal" data-target="#showPayment">
                        <i id="view-' . $item->id . '" class="fas fa-eye"></i> 
                    </button>
                    </div>';
            // <a href="/journals/' . $item->id . '/edit"
            // id="edit-' . $item->id . '"
            //   class="btn btn-success btn-xs"
            // >
            //   <i id="edit-' . $item->id . '" class="fas fa-edit"></i>
            // </a>
            // <button
            // id="delete-' . $item->id . '"
            //   type="button"
            //   class="btn btn-danger btn-xs"
            // >
            //   <i id="delete-' . $item->id . '" class="fas fa-trash"></i> 
            // </button>

            $journalList[] = $new_items;
        }
        return response()->json([
            "draw" => request()->get('draw'),
            "recordsTotal" => $journals->total(),
            "recordsFiltered" => $journals->total(),
            "data" => $journalList
        ]);
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
        //Journal::requestVerification($request);
        $acc_d = Account::select('uuid', 'type')->findOrFail($request->d_account_id);
        if (!Account::isValid($request->d_account_id)) {
            return response()->json(['error' => 'A conta ' . str_replace('.', '', $acc_d->uuid) . ' não aceita movimentos.'], 400);
        }

        $acc_c = Account::select('uuid', 'type')->findOrFail($request->c_account_id);
        if (!Account::isValid($request->c_account_id)) {
            return response()->json(['error' => 'A conta ' . str_replace('.', '', $acc_c->uuid) . ' não aceita movimentos.'], 400);
        }

        DB::beginTransaction();
        try {
            $config = [
                ['type' => 'debit', 'operation' => $acc_d->type == 'passive' ? 'sub' : 'sum', 'amount' => $request->effective_payment, 'account_id' => $request->d_account_id],
                ['type' => 'credit', 'operation' => $acc_c->type == 'passive' ? 'sum' : 'sub', 'amount' => $request->effective_payment, 'account_id' => $request->c_account_id],
            ];

            // first cast
            $journal = Journal::create([
                'ref' => Journal::invoiceNumber($request->created_at, 1),
                'amount' => $request->effective_payment,
                'description' => $request->description,
                'location_id' => 1,
                'journal_type_id' => 1,
                'created_at' => $request->created_at,
                'created_by' => Auth::id()
            ]);
            foreach ($config as $conf) {
                $conf = (object) $conf;
                $data = [
                    'description' => $request->description,
                    'amount' => $conf->amount,
                    'type' => $conf->type,
                    'operation' => $conf->operation,
                    'journal_id' => $journal->id,
                    'location_id' => 1,
                    'journal_type_id' => $journal->journal_type_id,
                    'account_id' => $conf->account_id,
                    'date' => $request->created_at,
                    'payment_method' => 'other',
                ];
                if ($conf->operation == 'sum') {
                    Util::increase((object) $data);
                } else {
                    Util::decrease((object) $data);
                }
            }


            DB::commit();
            //Util::set_log("Lançamento:" . $request->ref);
            return response()->json(['success' => 'Feito com sucesso.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response($e, 500);
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
        $transactions = DB::table('account_transactions')
            ->whereNull('account_transactions.deleted_at')
            ->where('account_transactions.journal_id', $id)
            ->join('accounts', 'accounts.id', 'account_transactions.account_id')
            ->select(
                'account_transactions.amount',
                'account_transactions.type',
                'accounts.uuid',
                'accounts.name'
            )
            ->get();

        return response()->json($transactions);
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