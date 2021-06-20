<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInventoryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_inventory_orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('vendor_id');
            $table->string('bill_no');
            $table->string('invoice_no');
            $table->string('due_date');
            $table->string('debit_Account');
            $table->string('total_amount');
            $table->string('transaction_details_id');
            $table->string('description');
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
        Schema::dropIfExists('purchase_inventory_orders');
    }
}
