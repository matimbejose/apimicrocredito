<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('name')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('ref_code')->nullable();
            $table->enum('type', ['manager', 'client', 'user', 'sa'])->default('user');
            $table->char('language', 7)->default('en');
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}