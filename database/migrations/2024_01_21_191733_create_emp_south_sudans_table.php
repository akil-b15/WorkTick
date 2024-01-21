<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpSouthSudansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_south_sudans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->integer('employee_id');
            $table->string('state', 192);
            $table->string('town', 192);
			$table->string('payam_one', 192);
			$table->string('payam_two', 192);
			$table->string('payam_three', 192);
            $table->string('gender', 192);
            $table->string('disability', 192);
            $table->string('disability_info', 192);
            $table->timestamps(6);
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emp_south_sudans');
    }
}
