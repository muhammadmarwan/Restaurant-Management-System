<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalaryPerMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_per_months', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('employee_id');
            $table->string('employee_table_id');
            $table->string('month');
            $table->string('year');
            $table->string('total_working_days');
            $table->string('leave_days')->default(0);
            $table->string('salary');
            $table->string('bonus')->default(0);
            $table->string('deductions')->default(0);
            $table->string('advance')->default(0);
            $table->string('net_salary');
            $table->string('paid_status')->default(0);
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
        Schema::dropIfExists('employee_salary_per_months');
    }
}
