<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->enum('doc_type', ['id', 'passport', 'dire'])->nullable();
            $table->date('emission_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->enum('activity', ['own', 'employed'])->nullable();
            $table->enum('residence', ['own', 'rent'])->nullable();
            $table->enum('type', ['individual', 'company'])->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('alternative_phone')->nullable();
            $table->bigInteger('family_phone')->nullable();
            $table->char('doc_nr', 19)->nullable();
            $table->char('nuit', 19)->nullable();
            $table->string('address')->nullable();
            $table->string('quarter')->nullable();
            $table->string('nationality')->nullable();
            $table->string('city')->nullable();
            $table->string('house_nr')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('ref_code')->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0.0);
            $table->decimal('balance', 15, 2)->default(0.0);
            $table->decimal('debit', 15, 2)->default(0.0);
            $table->decimal('credit', 15, 2)->default(0.0);
            $table->unsignedBigInteger('account_id')->default(1);
            // $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('business_id')->default(1);
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
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
        Schema::dropIfExists('customers');
    }
}