<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInventoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_inventory_products', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('vendor_id');
            $table->string('order_id');
            $table->string('product_id');
            $table->string('unit')->nullable();
            $table->string('quantity');
            $table->string('quantity_temp')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total');
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
        Schema::dropIfExists('purchase_inventory_products');
    }
}
