<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReturnProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_return_product_details', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('order_id');
            $table->string('sales_return_id');
            $table->string('product_id');
            $table->string('unitprice');
            $table->string('quantity');
            $table->string('discount')->nullable();
            $table->string('amount');
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
        Schema::dropIfExists('sales_return_product_details');
    }
}
