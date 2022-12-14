<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();
            $table->decimal('amount', 25, 2);
            $table->decimal('disbursed_amount', 25, 2)->nullable();
            $table->decimal('monthly_installment', 25, 2);
            $table->decimal('fixed_monthly', 25, 2)->default(0);
            $table->integer('maturity');
            $table->enum('status', ['requested', 'approved', 'disapproved', 'disbursed', 'refunded', 'restructured', 'canceled', 'finished'])->default('requested');
            $table->boolean('delayed_status')->default(0);
            $table->decimal('delay_fees', 25, 2)->default(0);
            $table->decimal('total_fees', 25, 2)->default(0);
            $table->date('disbursed_at')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('refunded_at')->nullable();
            $table->unsignedBigInteger('credit_type')->nullable();
            $table->foreign('credit_type')->references('id')->on('credit_types')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('loans');
    }
}