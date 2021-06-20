<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetupAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('account_type');
            $table->string('account_id')->nullable();
            $table->string('bank_status')->default(0);
            $table->string('selected_status')->default(1);
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
        Schema::dropIfExists('setup_accounts');
    }
}
