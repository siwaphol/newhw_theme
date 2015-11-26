<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentSemesterYearTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('semester_year', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('semester',1);
            $table->char('year',4);
            $table->char('use',1)->default('0');
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
        Schema::dropIfExists('semester_year');
	}

}
