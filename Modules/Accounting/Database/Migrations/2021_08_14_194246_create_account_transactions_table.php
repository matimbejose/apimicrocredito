<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('description')->nullable();
            $table->decimal('initial_amount', 15, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);

            # transactions types
            $table->integer('invoice_id')->nullable();
            $table->integer('bill_id')->nullable();
            $table->integer('journal_id')->nullable();
            $table->integer('loan_id')->nullable();

            $table->integer('business_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('transaction_id')->nullable();

            $table->integer('cost_center_id')->nullable();
            $table->unsignedBigInteger('journal_type_id');

            $table->integer('class_id')->nullable();
            $table->enum('type', ['debit', 'credit']);
            $table->enum('operation', ['sum', 'sub']);

            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('account_transactions');
    }
}