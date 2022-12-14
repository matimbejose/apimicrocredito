<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUserTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('business_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('business_id')->unsigned()->index();
        //    $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
          //  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['business_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_user');
    }
}
