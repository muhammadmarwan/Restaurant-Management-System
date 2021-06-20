<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_informations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('country');
            $table->string('total_employees');
            $table->string('email_id');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('company_informations');
    }
}
