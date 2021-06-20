<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_sales', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('token_no');
            $table->string('customer');
            $table->string('phone');
            $table->longtext('address');
            $table->string('total_price');
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
        Schema::dropIfExists('delivery_sales');
    }
}
