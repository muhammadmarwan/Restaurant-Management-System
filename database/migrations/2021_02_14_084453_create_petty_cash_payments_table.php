<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->date('date');
            $table->string('amount');
            $table->string('bill_no');
            $table->string('narration');
            $table->string('debit_account_id');
            $table->string('transaction_details_id');
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
        Schema::dropIfExists('petty_cash_payments');
    }
}
