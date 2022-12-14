<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->string('name');
            $table->string('name_to_show');
            $table->string('model_name')->nullable();
            $table->string('guard_name')->default('api');
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
        Schema::drop('permissions');
    }
}
