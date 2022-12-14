<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('country', 100);
            $table->string('currency', 100);
            $table->string('code', 25)->nullable();
            $table->string('symbol', 25)->nullable();
            $table->string('thousand_separator', 10)->default(' ');
            $table->string('decimal_separator', 10)->default('.');
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
        Schema::dropIfExists('currencies');
    }
}
