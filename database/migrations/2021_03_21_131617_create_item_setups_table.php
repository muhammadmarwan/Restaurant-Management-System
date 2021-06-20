<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_setups', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('category');
            $table->string('item_name')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('selected_status')->default(0);
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
        Schema::dropIfExists('item_setups');
    }
}
