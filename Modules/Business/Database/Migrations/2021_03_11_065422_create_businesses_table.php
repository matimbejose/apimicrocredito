<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('business_name');
            $table->string('phone');
            $table->char('owner_id', 15);
            $table->string('province');
            $table->string('city');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->integer('nuit')->nullable();
            $table->integer('currency_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->string('tax', 100)->default('17');
            $table->string('time_zone')->default('Asia/Kolkata');
            $table->tinyInteger('fy_start_month')->default(1);
            $table->enum('accounting_method', ['fifo', 'lifo', 'avco'])->default('fifo');
            $table->enum('billing_type', ['fixed', 'variable'])->default('fixed');
            $table->decimal('default_sales_discount', 5, 2)->nullable();
            $table->enum('sell_price_tax', ['includes', 'excludes'])->default('excludes');
            //  $table->foreign('currency_id')->references('id')->on('currencies');
            $table->string('logo')->nullable();
            $table->string('sku_prefix')->nullable();
            $table->boolean('enable_tooltip')->default(1);
            $table->decimal('charges_fee', 5, 2)->nullable();
            $table->string('acc_clients')->nullable();
            $table->string('acc_advances')->nullable();
            $table->string('acc_charges')->nullable();
            $table->string('acc_increases')->nullable();
            $table->string('acc_finantial_incomes')->nullable();
            $table->string('acc_finantial_looses')->nullable();
            //   $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('businesses');
    }
}