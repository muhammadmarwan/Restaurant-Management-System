<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_entries', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('vendor_id');
            $table->string('vendor_account_no');
            $table->string('debit_account_no');
            $table->string('net_amount');
            $table->string('tax');
            $table->string('amount');
            $table->string('due_date');
            $table->string('invoice_no');
            $table->string('bill_no');
            $table->string('transaction_details_id');
            $table->longtext('description');
            $table->string('payment_status')->default(0);
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
        Schema::dropIfExists('purchase_entries');
    }
}
