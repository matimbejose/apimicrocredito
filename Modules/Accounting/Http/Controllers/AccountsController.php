<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountTransaction;
use Modules\Accounting\Entities\JournalType;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Http\Requests\AccountRequest;
use Modules\Accounting\Http\Requests\AccountUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Business\Entities\Business;

class AccountsController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Account::class);
        $accounts = DB::table('accounts')
            ->whereNull('deleted_at');


        $classes = DB::table('account_classes')->get();

        $class_id = request()->get('class_id', null);
        if (!empty($class_id)) {
            $accounts->where('class_id', $class_id);
        }

        $search_value = request()->get('search');
        if (!empty($search_value['value'])) {
            $search = $search_value['value'];
            $accounts->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', '%' . $search . '%');
            });
        }

        $order = request()->get('order');
        $order_by = 'uuid';
        $order_diration = 'asc';
        if (!empty($order['column']) && $order['column'] != 0) {
            $order_by = $order['column'];
            $order_diration = $order['dir'];
        }


        $accounts = $accounts->select('id', 'name', 'type', 'uuid')
            ->orderBy($order_by, $order_diration)
            ->paginate(!empty(request()->get('length')) ? request()->get('length') : 20);


        $accs = [];
        foreach ($accounts->items() as $item) {
            $new_items = [];
            $new_items[] = join(explode('.', $item->uuid));
            $new_items[] = $item->name;
            $new_items[] = $item->type == 'active' ? 'Activo' : 'Passivo';
            $new_items[] = '<div class="pull-right no-print">
                      <button
                      id="edit-' . $item->id . '"
                        class="btn btn-success btn-xs"
                        data-toggle="modal"
                        data-target="#createNewAccount"
                      >
                        <i class="glyphicon glyphicon-edit"></i> Editar
                      </button>
                      <button
                      id="delete-' . $item->id . '"
                        type="button"
                        class="btn btn-danger btn-xs"
                      >
                        <i class="glyphicon glyphicon-trash"></i> Apagar
                      </button>
                    </div>';

            $accs[] = $new_items;
        }
        return response()->json([
            "draw" => request()->get('draw'),
            "recordsTotal" => $accounts->total(),
            "recordsFiltered" => $accounts->total(),
            "data" => $accs
        ]);
    }

    public function search_accounts(Request $req)
    {
        $this->authorize('view', Account::class);
        if ($req->has('q')) {
            $search = $req->q;
            $in_case_uuid = join(".", str_split(str_replace('.', '', $search), 1));
            //return $in_case_uuid;
            $accounts = Account::where(function ($query) use ($search, $in_case_uuid) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('uuid', 'like', '%' . $search . '%');
                $query->orWhere('uuid', 'like', '%' . $in_case_uuid . '%');
            })
                //     ->where('is_account', 1)
                ->select('id', 'name', 'uuid')
                ->get();
        }

        return response()->json($accounts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_if_has_transactions($id)
    {
        $this->authorize('view', Account::class);
        $transactions_acc = AccountTransaction::whereNull('deleted_at')->where('account_id', $id)->get();
        $account = Account::find($id);

        if (count($transactions_acc) > 0 && $account->balance > 0) {
            return response()->json(['hasTransactions' => true]);
        } else {
            return response()->json(['hasTransactions' => false]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response  
     */
    public function get_all()
    {
        $this->authorize('view', Account::class);
        return response()->json(['accounts' => Account::whereNull('deleted_at')->select('uuid', 'name')->get()]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        $this->authorize('create', Account::class);
        $business = Business::first();
        $pre_selected_accs = [
            $business->acc_advances,
            $business->acc_charges,
            $business->acc_increases,
            $business->acc_finantial_incomes,
            $business->acc_finantial_looses
        ];

        $uuid = join('.', str_split(str_replace('.', '', $request->uuid)));

        $account = Account::find($request->account_id);

        if (in_array($account->uuid, $pre_selected_accs)) {
            return response()->json(['error' => 'Nao pode criar subcontas em uma conta pré definida.'], 400);
        }

        $account_cleaned = str_replace('.', '', $account->uuid);

        if (strpos($request->uuid, $account_cleaned) === false) {
            return response()->json(['error' => 'Certifique que a subconta pertence a conta selecionada.'], 400);
        }

        $account_exists = Account::where('uuid', $uuid)->first();
        if ($account_exists != null) {
            return response()->json(['error' => 'A conta ' . $uuid . ' ja exitse'], 400);
        }
        DB::beginTransaction();
        try {
            Account::where('id', $request->account_id)->update(['is_account' => 0]);

            $new_account = Account::create([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'balance' => 0,
                'initial_balance' => 0,
                'notes' => $request->description,
                'account_number' => $uuid,
                'type' => $account->type,
                'balance' => 0,
                'initial_balance' => 0,
                'uuid' => $uuid,
                'class_id' => $account->class_id,
                'parent_id' => $account->uuid,
                'master_parent_id' => isset($account->master_parent_id) && $account->master_parent_id != null ? $account->master_parent_id : $account->uuid,
            ]);

            $transactions_acc = AccountTransaction::whereNull('deleted_at')->where('account_id', $request->account_id)->get();

            if (count($transactions_acc) > 0) {
                Account::where('id', $new_account->id)->update(['balance' => $account->balance]);
                Account::where('id', $account->id)->update(['balance' => 0]);

                foreach ($transactions_acc as $trans) {
                    AccountTransaction::where('id', $trans->id)->update(['account_id' => $new_account->id]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Criado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['error' => 'Erro do sistema.'] . 400);
        }
    }



    public function extracts()
    {
        $this->authorize('view', Account::class);
        $end_date = DB::table('account_transactions')->select('created_at')->latest('created_at')->first();
        $end_date = $end_date != null ? explode(' ', $end_date->created_at)[0] : date('Y-m-d');
        //dd($end_date);
        return response()->json([
            'end_date' => $end_date,
            'accounts' => DB::table('accounts')
                ->whereNull('deleted_at')
                ->select('uuid', 'id', 'name')
                ->orderBy('uuid', 'asc')
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function extractacc(Request $request)
    {
        $this->authorize('view', Account::class);
        if (!Account::isvalid($request->account_id)) {
            return response()->json(['error' => 'Conta sem movimentos.']);
        }
        //Util::ac_gambia();
        $extract_list = [];
        $extract_row = [];
        $last_balance = 0;
        $debit_sum = 0;
        $credit_sum = 0;
        $a_balance = 0;
        $a_debit_sum = 0;
        $a_credit_sum = 0;
        $balance = 0;
        $debit_initial = 0;
        $credit_initial = 0;
        $balance_initial = 0;
        $condition = true;
        $limit_id = 0;

        $account_info = Account::find($request->account_id);
        if ($account_info->class_id == 6 || $account_info->class_id == 7) {
            $init_extracts = DB::table('account_transactions')
                ->where('account_id', $request->account_id)
                ->whereNull('deleted_at')
                ->where('created_at', 'like', '%' . explode('-', $request->from)[0] . '%')
                ->whereDate('created_at', '<', $request->from)
                ->orderBy('created_at', 'asc')
                ->select('initial_amount', 'amount', 'type')
                ->get();
        } else {
            $init_extracts = DB::table('account_transactions')
                ->where('account_id', $request->account_id)
                ->whereNull('deleted_at')
                ->whereDate('created_at', '<', $request->from)
                ->orderBy('created_at', 'asc')
                ->select('initial_amount', 'amount', 'type')
                ->get();
        }

        foreach ($init_extracts as $extract) {

            if ($extract->type == 'debit') {
                $debit_initial += floatval($extract->amount);
            } elseif ($extract->type == 'credit') {
                $credit_initial += floatval($extract->amount);
            }
        }
        $balance_initial = $debit_initial - $credit_initial;



        $a_extracts = DB::table('account_transactions')
            ->where('account_id', $request->account_id)
            ->whereDate('created_at', '<=', $request->to)
            ->orderBy('created_at', 'asc')
            ->whereNull('deleted_at')
            ->select('initial_amount', 'amount', 'type')
            ->get();


        foreach ($a_extracts as $extract) {

            if ($extract->type == 'debit') {
                $a_debit_sum = floatval($a_debit_sum) + floatval($extract->amount);
            } elseif ($extract->type == 'credit') {
                $a_credit_sum = floatval($a_credit_sum) + floatval($extract->amount);
            }
        }
        $a_balance = $a_debit_sum - $a_credit_sum;

        $extracts = DB::table('account_transactions')
            ->where('account_id', $request->account_id)
            ->orderBy('created_at', 'asc')
            ->whereNull('deleted_at')
            ->whereBetween('created_at', [$request->from, $request->to])
            ->get();

        if (count($extracts) <= 0) {
            return response()->json(['error' => 'Extrato vazio.']);
        }


        $last_balance = $balance_initial;
        // dd($balance_initial);

        foreach ($extracts as $extract) {
            if ($condition) { //!14dyg1u
                $limit_id = $extract->id;
            }

            //  dd($extract->divers_id);

            $get_ref = [];

            $code = null;


            if ($extract->journal_id != null) {
                $journal = Journal::find($extract->journal_id);
                $get_ref = $journal != null ? $journal->ref : null;
                $j_type = JournalType::find($journal->journal_type_id);
                $code = $j_type != null ? $j_type->uuid : null;
            }

            if ($extract->type == 'debit') {
                $extr = [
                    'code' => $code,
                    'date' => explode(' ', $extract->created_at)[0],
                    'invoice_ref' => $get_ref,
                    'description' => $extract->description,
                    'debit' => $extract->amount,
                    'credit' => 0,
                    'f_balance' => $last_balance == 0 ? 0 + $extract->amount : $last_balance + $extract->amount,
                ];

                $debit_sum += $extract->amount;
                //$debit_sum = $debit_sum;
            } elseif ($extract->type == 'credit') {
                $extr = [
                    'date' => explode(' ', $extract->created_at)[0],
                    'code' => $code,
                    'invoice_ref' => $get_ref,
                    'description' => $extract->description,
                    'debit' => 0,
                    'credit' => $extract->amount,
                    'f_balance' => $last_balance == 0 ? 0 - $extract->amount : $last_balance - $extract->amount,
                ];

                $credit_sum += $extract->amount;
                //$credit_sum = $credit_sum;at once
            }
            $last_balance = $extr['f_balance'];
            array_push($extract_list, $extr);
            $condition = false;
        }


        $balance = floatval($debit_sum) - floatval($credit_sum);


        $acc_name = DB::table('accounts')->where('id', $request->account_id)->first()->name;
        $acc_nr = DB::table('accounts')->where('id', $request->account_id)->first()->uuid;


        return response()->json([
            'extracts' => $extract_list,
            'credit' => $credit_sum,
            'debit' => $debit_sum,
            'balance' => $balance,
            'a_credit' => $a_credit_sum,
            'a_debit' => $a_debit_sum,
            'debit_initial' => $debit_initial,
            'credit_initial' => $credit_initial,
            'balance_initial' => $balance_initial,
            'a_balance' => $a_balance,
            'acc_name' => $acc_name,
            'acc_nr' => $acc_nr
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Account::class);
        $account = Account::find($id);
        //$parent_acc_id = Account::where('uuid', $account->parent_id)->first()->id;
        //$account = (array) $account;
        //$account['parent'] = $parent_acc_id;
        //$account = (Object) $account;

        return response()->json($account);
    }
    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function accounts_chart()
    {
        $this->authorize('view', Account::class);
        $accounts = Account::where('is_account', '1')->select('uuid', 'name')->get();

        $accountsArray = [];
        foreach ($accounts as $acc) {
            $acc_uuid = str_replace('.', '', $acc->uuid) . '-' . $acc->name;
            array_push($accountsArray, $acc_uuid);
        }

        return response()->json(['accs' => $accountsArray]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        $this->authorize('edit', Account::class);
        $uuid = join('.', str_split(str_replace('.', '', $request->uuid)));

        $account = Account::find($request->account_id);

        $account_cleaned = str_replace('.', '', $account->uuid);

        if (strpos($request->uuid, $account_cleaned) === false) {
            return response()->json(['error' => 'Certifique que a subconta pertence a conta selecionada.'], 400);
        }

        DB::beginTransaction();
        try {
            Account::where('id', $request->account_id)->update(['is_account' => 0]);

            $new_account = Account::find($id)->update([
                'created_by' => Auth::id(),
                'name' => ucfirst($request->name),
                'notes' => $request->description,
                'uuid' => $uuid,
                'class_id' => $account->class_id,
                'parent_id' => $account->uuid,
                'master_parent_id' => isset($account->master_parent_id) && $account->master_parent_id != null ? $account->master_parent_id : $account->uuid,
            ]);

            $transactions_acc = AccountTransaction::whereNull('deleted_at')->where('account_id', $request->account_id)->get();

            if (count($transactions_acc) > 0) {
                Account::where('id', $new_account->id)->update(['balance' => $account->balance]);
                Account::where('id', $account->id)->update(['balance' => 0]);

                foreach ($transactions_acc as $trans) {
                    AccountTransaction::where('id', $trans->id)->update(['account_id' => $new_account->id]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Actualizado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['error' => 'Erro do sistema.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Account::class);
        $check_data = AccountTransaction::where('account_id', $id)->first();

        if ($check_data != null) {
            return response()->json(['error' => 'Operação não permitida! Conta em uso.']);
        }


        $account = Account::withTrashed()->where('id', $id)->firstOrFail();
        if ($account->trashed()) {
            $account->forceDelete();
        } else {
            $account->delete();
        }
        return response()->json(['success' => 'Conta movido para lata de lixo!']);
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
        return response()->json(Account::withCustomers($trashed));
    }
    public function restore($id)
    {
        $account = Account::withTrashed()->where('id', $id)->firstOrFail();
        session()->flush('success', 'Conta restaurado com sucesso!');
        $account->restore();
    }
}