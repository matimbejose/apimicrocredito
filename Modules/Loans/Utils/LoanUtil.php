<?php

namespace Modules\Loans\Utils;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\Journal;
use Modules\Business\Entities\Business;
use Modules\Customers\Entities\Customer;
use Modules\Loans\Entities\Loan;
use Modules\Loans\Entities\LoanSchedule;

class LoanUtil
{

  public static function getScheduledDate($type, $value, $is_first = false)
  {
    $today = Carbon::now('Africa/Maputo');

    # no caso da taxa anual so se aplicara se a pagamentos mensais, trimestrais ou mais
    # o maximo do input pra dias sera 31, para meses, sera 12, para semanas 4
    # fazer com que se sobrar alguma parcela, caso seja taxa mensal, que seja pago no ultimo dia do mes
    # se for anual que seja pago no ultimo mes do ano
    # Para obter o dividendo faremos, se for mensal, 30 / dias caso seja anual sera 12 / meses
    // $tmp = '';
    // if ($type == 'monthly') {
    //   $tmp = $today->addDays(intval($value))->toFormattedDateString();
    // } else if ($type == 'yearly') {
    //   $tmp = $today->addMonths(intval($value))->toFormattedDateString();
    // }
    return $today->addMonths($value)->toFormattedDateString();
  }

  public static function getFormater($type, $value)
  {
    if ($type == 'monthly') {
      return 30 / intval($value);
    }

    if ($type == 'yearly') {
      return 12 / intval($value);
    }
  }

  public static function castDisburse($description, $amounts, $created_at, $loan_id, $request_account, $client_acc, $location_id)
  {
    $business = Business::firstOrFail();

    $acc_increases = Account::where('uuid', $business->acc_increases)->firstOrFail();
    $acc_charges = Account::where('uuid', $business->acc_charges)->firstOrFail();
    $config = [
      ['type' => 'debit', 'operation' => 'sum', 'amount' => $amounts['debit'], 'account_id' => $client_acc],
      ['type' => 'credit', 'operation' => 'sub', 'amount' => $amounts['credit1'], 'account_id' => $request_account],
      [
        'type' => 'credit',
        'operation' => 'sub',
        'amount' => $amounts['credit2'],
        'account_id' => $acc_increases->id
      ],
      ['type' => 'credit', 'operation' => 'sum', 'amount' => $amounts['credit3'], 'account_id' => $acc_charges->id]
    ];



    // first cast
    $journal = Journal::create([
      'ref' => Journal::invoiceNumber($created_at, 1),
      'amount' => $amounts['debit'],
      'description' => $description,
      'location_id' => $location_id,
      'journal_type_id' => 1,
      'loan_id' => $loan_id,
      'created_at' => $created_at,
      'created_by' => Auth::id()
    ]);
    foreach ($config as $conf) {
      $conf = (object) $conf;
      $data = [
        'description' => $description,
        'amount' => $conf->amount,
        'type' => $conf->type,
        'operation' => $conf->operation,
        'journal_id' => $journal->id,
        'location_id' => $location_id,
        'journal_type_id' => $journal->journal_type_id,
        'account_id' => $conf->account_id,
        'date' => $created_at,
        'payment_method' => 'other',
      ];
      if ($conf->operation == 'sum') {
        Util::encrease((object) $data);
      } else {
        Util::decrease((object) $data);
      }
    }
  }

  public static function castLoanPayment($description, $account_id, $customer_account_id, $amount, $created_at, $bill_id, $customer_id, $payment)
  {
    if (!Account::isValid($account_id) || !Account::isValid($customer_account_id)) {
      throw new Exception("Esta conta nao aceita movimentos");
    }

    $config = [
      ['type' => 'debit', 'operation' => 'sum', 'amount' => $amount, 'account_id' => $account_id],
      ['type' => 'credit', 'operation' => 'sub', 'amount' => $amount, 'is_customer' => true, 'account_id' => $customer_account_id]
    ];
    if ($amount <= 0) {
      return;
    }
    // first cast
    $journal = Journal::create([
      'ref' => Journal::invoiceNumber($created_at, 1),
      'amount' => $amount,
      'description' => $description,
      'location_id' => 1,
      'journal_type_id' => 1,
      'bill_id' => $bill_id,
      'created_at' => $created_at,
      'created_by' => Auth::id(),
      'payment_id' => $payment->id
    ]);
    foreach ($config as $conf) {
      $conf = (object) $conf;
      $data = [
        'description' => $description,
        'amount' => $conf->amount,
        'type' => $conf->type,
        'operation' => $conf->operation,
        'journal_id' => $journal->id,
        'location_id' => 1,
        'customer_id' => isset($conf->is_customer) ? $customer_id : null,
        'journal_type_id' => $journal->journal_type_id,
        'account_id' => $conf->account_id,
        'date' => $created_at,
        'payment_method' => 'other',
      ];
      if ($conf->amount > 0) {
        if ($conf->operation == 'sum') {
          Util::encrease((object) $data);
        } else {
          Util::decrease((object) $data);
        }
      }
    }
    return $journal;
  }

  public function loansDelayChecker()
  {
    // Steps
    // check each loan schedule date
    // If one is out of the scheduled payment date then calculate the Delay Fee and sum it to the customer acc
    // If is a pay day of one of them, then check the customer account balance, if there is enougth balance
    // Make the payment, pay the scheduled amount
    // Before applying fees we mus first check wether the customer balance is enougth to pay
    // we add the balance to the client balance column
    $schedules = LoanSchedule::whereNull('effective_date')->get();
    DB::beginTransaction();
    try {
      //code...

      foreach ($schedules as $schedule) {
        $scd = \Carbon\Carbon::parse($schedule->scheduled_date);
        $now = \Carbon\Carbon::now();
        $customer = $schedule->loan->customer;
        $delay_tax = $schedule->loan->monthly_installment;
        $next_payment = LoanUtil::customerNextPaymentSchedule($customer->id);
        $amount_to_pay = floatval($next_payment->effective_payment) + floatval($next_payment->delay_feed);
        if ($now->greaterThan($scd)) {
          Loan::find($schedule->loan_id)->update(['delayed_status' => 1]);
          $diff_in_days = $now->diffInDays($scd);
          $fee = floatval($schedule->fixed_monthly) * floatval($delay_tax) / 100;
          $total_fee = $fee * $diff_in_days;
          $schedule->increment('delay_fees', $total_fee);

          // we need to cast the incremented to the accounting
          $this->castDelayFee("Referente a " . $schedule->description . " do " . $customer->name, $total_fee, $now->isoFormat("YYYY-MM-DD"), $schedule->loan_id, $customer->account_id, 1);
        }

        if ($now->isoFormat('YYYY-MM-DD') === $scd->isoFormat('YYYY-MM-DD')) {
          // check client balance
          if ($customer->balance >= $amount_to_pay) {
            // decrease the balance
            Customer::decreaseBalance($customer->id, $amount_to_pay);
            // mark schedule as runned
            $schedule->update(['effective_date' => $now->isoFormat('YYYY-MM-DD')]);
          }
        }
      }

      // check if all installments are paid
      $loans = Loan::where('status', 'disbursed')->get();
      foreach ($loans as $loan) {
        $not_paid_instlls = LoanSchedule::where('loan_id', $loan->id)->whereNotNull('effective_date')->get();
        if (count($not_paid_instlls) === 0) {
          $loan->update(['status' => 'finished']);
        }
      }
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      return response($e->getMessage(), 500);
    }
    // we are missing to update the loans to delayed status
  }

  private function castDelayFee($description, $amount, $created_at, $loan_id, $account_client, $location_id)
  {
    $business = Business::firstOrFail();

    $acc_finantial_incomes = Account::where('uuid', $business->acc_finantial_incomes)->firstOrFail()->id;
    $c_account = Account::where('id', $account_client)->firstOrFail();

    $config = [
      ['type' => 'debit', 'operation' => 'sum', 'amount' => $amount, 'account_id' => $c_account->id],
      ['type' => 'credit', 'operation' => 'sum', 'amount' => $amount, 'account_id' => $acc_finantial_incomes]
    ];

    // first cast

    $journal = Journal::create([
      'ref' => Journal::invoiceNumber($created_at, 1),
      'amount' => $amount,
      'description' => $description,
      'location_id' => $location_id,
      'journal_type_id' => 1,
      'loan_id' => $loan_id,
      'created_at' => $created_at,
      'created_by' => 1
    ]);
    foreach ($config as $conf) {
      $conf = (object) $conf;
      $data = [
        'description' => $description,
        'amount' => $conf->amount,
        'type' => $conf->type,
        'operation' => $conf->operation,
        'journal_id' => $journal->id,
        'location_id' => $location_id,
        'journal_type_id' => $journal->journal_type_id,
        'account_id' => $conf->account_id,
        'date' => $created_at,
        'payment_method' => 'other',
      ];
      if ($conf->operation == 'sum') {
        Util::encrease((object) $data);
      } else {
        Util::decrease((object) $data);
      }
    }
  }

  public static function customerNextPaymentSchedule($id): object
  {
    $scheduled = Loan::where('loans.customer_id', $id)
      ->join('loan_schedules', 'loans.id', 'loan_schedules.loan_id')
      ->whereNull('loan_schedules.effective_date')
      ->first();

    return $scheduled;
  }
}