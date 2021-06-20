<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_sale_items', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('sale_id');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('unit_price');
            $table->string('total_amount');
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
        Schema::dropIfExists('rest_sale_items');
    }
}
