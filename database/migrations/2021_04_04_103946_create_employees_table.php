<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('name');
            $table->string('designation');
            $table->string('employee_id');
            $table->string('age');
            $table->date('date_of_joining');
            $table->string('emirates_id');
            $table->string('nationality');
            $table->string('email_id');
            $table->string('phone');
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
        Schema::dropIfExists('employees');
    }
}
