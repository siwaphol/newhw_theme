<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworkAssignmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('homework', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('course_id',6);
            $table->char('section',3)->nullable();
            $table->string('name',50);
            $table->char('type_id',3)->nullable();
            $table->string('detail',100)->nullable();
            $table->timestamp('assign_date');
            $table->timestamp('due_date');
            $table->timestamp('accept_date');
            $table->string('created_by',100)->nullable();
            $table->char('semester',1);
            $table->char('year',4);
            $table->timestamps();

            $table->unique(array('course_id','section','name','type_id','semester','year'));
        });

        Schema::create('homework_student', function(Blueprint $table)
        {
            $table->increments('id');
            $table->char('course_id',6);
            $table->char('section',3);
            $table->integer('homework_id');
            $table->string('homework_name',50);
            $table->char('student_id',9);
            $table->integer('status');
            $table->timestamp('submitted_at');
            $table->char('semester',1);
            $table->char('year',4);
            $table->timestamps();
        });

        Schema::create('homework_types', function(Blueprint $table)
        {
            $table->char('id',3);
            $table->string('extension',100);
            $table->timestamps();

            $table->primary('id');
            $table->unique('extension');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homework');
        Schema::dropIfExists('homework_student');
        Schema::dropIfExists('homework_types');
    }

}
