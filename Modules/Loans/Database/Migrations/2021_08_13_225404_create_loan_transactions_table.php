<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();
            $table->date('scheduled_date');
            $table->date('effective_date');
            $table->decimal('effective_payment', 25, 2);
            $table->decimal('scheduled_payment', 25, 2);
            $table->decimal('initial_balance', 25, 2);
            $table->decimal('fees', 25, 2);
            $table->decimal('delay_fees', 25, 2);
            $table->decimal('main_capital', 25, 2);
            $table->decimal('final_balance', 25, 2);
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
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
        Schema::dropIfExists('loan_transactions');
    }
}