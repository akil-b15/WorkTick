<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('goal_type', 192)->nullable();
			$table->string('subject', 192)->nullable();
			$table->integer('employee_id');
			$table->foreign('employee_id')->references('id')->on('employees');
			$table->string('target_achievement', 192)->nullable();
			$table->date('start_date');
			$table->date('end_date');
            $table->unsignedTinyInteger('ratings')->default(0);
            $table->unsignedTinyInteger('progress')->default(0);
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
        Schema::dropIfExists('performances');
    }
}
