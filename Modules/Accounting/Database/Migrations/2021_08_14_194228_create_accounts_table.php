<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->char('account_number', 30)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('initial_balance', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('uuid')->unique()->nullable();
            $table->string('parent_id')->nullable();
            $table->string('master_parent_id')->nullable();
            $table->integer('class_id');
            $table->decimal('budget', 20, 2)->nullable();
            $table->boolean('is_account')->default(1);
            $table->boolean('status')->default(1);
            $table->enum('type', ['active', 'passive']);
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}