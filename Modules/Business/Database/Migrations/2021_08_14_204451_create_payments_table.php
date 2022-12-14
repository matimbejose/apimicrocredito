<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code', 25)->nullable();
            $table->decimal('amount', 25, 4);
            $table->enum('method', ['cash', 'cheque', 'bank_transfer', 'mpesa']);

            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('loan_transaction_id')->nullable();
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->unsignedBigInteger('loan_scheduled_id')->nullable();
            $table->date('payment_date');
            $table->string('receipt_number')->nullable();
            $table->string('attachment')->nullable();
            $table->string('notes')->nullable();
            $table->string('ref_payment')->nullable();

            //bank fields
            $table->string('cheque_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->date('cheque_date')->nullable();

            // mpesa fields
            $table->string('transaction_type')->nullable();
            $table->string('trans_id')->nullable()->unique();
            $table->string('trans_time')->nullable();
            $table->string('business_short_code')->nullable();
            $table->string('bill_ref_number')->nullable();

            $table->string('mpesa_number')->nullable();
            $table->string('mpesa_first_name')->nullable();
            $table->string('mpesa_middle_name')->nullable();
            $table->string('mpesa_last_name')->nullable();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}