<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->float('net_payble', 15,2);
            $table->string('salary_month');
            $table->integer('status');
            $table->float('basic_salary', 15,2);
            $table->json('allowance');
            $table->json('commission');
            $table->json('loan');
            $table->json('saturation_deduction');
            $table->json('other_payment');
            $table->json('overtime');
            $table->integer('created_by');
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
        Schema::dropIfExists('pay_slips');
    }
}
