<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->char('id',9);
			$table->string('username',100)->nullable();
			$table->char('role_id',4);
            $table->string('firstname_th',100)->nullable();
            $table->string('firstname_en',100)->nullable();
            $table->string('lastname_th',100)->nullable();
            $table->string('lastname_en',100)->nullable();
            $table->string('email',100)->nullable();
            $table->char('faculty_id',2)->nullable();
            $table->char('semester',1)->nullable();
            $table->char('year',4)->nullable();
			$table->timestamps();

            $table->primary('id');
		});

        /**
         * Role is keep as 4-digit binary
         *  0000
         *  0001 = student
         *  0010 = ta
         *  0100 = teacher
         *  1000 = admin
         *  0011 = ta, student
         * @return void
         */
        Schema::create('ref_roles', function(Blueprint $table)
        {
            $table->char('id',4);
            $table->string('detail')->nullable();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('faculties', function(Blueprint $table)
        {
            $table->char('id',2)->unique();
            $table->string('name_th')->nullable();
            $table->string('name_en')->nullable();
            $table->timestamps();

            $table->primary('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
        Schema::dropIfExists('ref_roles');
        Schema::dropIfExists('faculties');
    }

}
