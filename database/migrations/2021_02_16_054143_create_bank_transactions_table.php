<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_id');
                $table->string('transaction_type');
                $table->string('account_id');
                $table->string('bank_account');
                $table->string('bill_no');
                $table->string('amount');
                $table->date('date');
                $table->string('narration');
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
        Schema::dropIfExists('bank_transactions');
    }
}
