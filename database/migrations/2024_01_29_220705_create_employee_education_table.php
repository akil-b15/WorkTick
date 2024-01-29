<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_education', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
            $table->integer('employee_id');
            $table->string('institution', 192);
            $table->string('qualification_attained', 192);
            $table->string('field_of_study_one', 192);
            $table->string('field_of_study_two', 192);
            $table->date('completion_year')->nullable();
            $table->string('qualification_obtained_in', 192);
            $table->string('highest_qualification', 192);
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
        Schema::dropIfExists('employee_education');
    }
}
