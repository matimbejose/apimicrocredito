<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();
            $table->date('scheduled_date');
            $table->date('effective_date')->nullable();
            $table->decimal('scheduled_payment', 25, 2);
            $table->decimal('capital_fee', 25, 2)->default(0);
            $table->decimal('delay_fees', 25, 2)->default(0);
            $table->decimal('fixed_monthly', 25, 2)->default(0);
            $table->decimal('total_monthly', 25, 2)->default(0);
            $table->decimal('residual', 25, 2)->default(0);
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('loan_transaction_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('loan_transaction_id')->references('id')->on('loan_transactions')->onDelete('cascade');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
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
        Schema::dropIfExists('loan_schedules');
    }
}