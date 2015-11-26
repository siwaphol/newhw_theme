<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('courses', function(Blueprint $table)
        {
            $table->char('id',6);
            $table->string('name',50);
            $table->string('detail',255)->nullable();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('course_section', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('course_id',6);
            $table->char('section',3);
            $table->char('teacher_id',9);
            $table->char('semester',1);
            $table->char('year',4);
            $table->timestamps();
        });

        Schema::create('course_student', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('course_id',6);
            $table->char('section',3);
            $table->char('student_id',9);
            $table->char('status',1)->nullable();
            $table->char('semester',1);
            $table->char('year',4);
            $table->timestamps();
        });

        Schema::create('course_ta', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('course_id',6);
            $table->char('section',3);
            $table->char('student_id',9);
            $table->char('semester',1);
            $table->char('year',4);
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
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_section');
        Schema::dropIfExists('course_student');
        Schema::dropIfExists('course_ta');
    }

}
