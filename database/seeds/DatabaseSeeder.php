<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(HomeworkTableSeeder::class);
        $this->call(CurrentSemesterYearTableSeeder::class);

        Model::reguard();
    }

}

class UsersTableSeeder extends Seeder {
    public function run()
    {
        $date = new \DateTime;
        DB::table('users')->delete();
        DB::table('ref_roles')->delete();
        DB::table('faculties')->delete();

        User::create([
            'id' => '000000001',
            'username' => 'kanokkorn_tumma',
            'role_id' => '0100',
            'firstname_th' => 'กนกกร',
            'firstname_en' => 'Kanokkorn',
            'lastname_th' => 'ธรรมมา',
            'lastname_en' => 'Tumma',
            'email' => 'kanokkorn_tumma@cmu.ac.th',
            'faculty_id' => '05',
            'semester' => '1',
            'year' => '2557']);
        User::create([
            'id' => '540510828',
            'username' => 'siwaphol_boonpan',
            'role_id' => '1000',
            'firstname_th' => 'ศิวพล',
            'firstname_en' => 'Siwaphol',
            'lastname_th' => 'บุญปั๋น',
            'lastname_en' => 'Boonpan',
            'email' => 'siwaphol_boonpan@cmu.ac.th',
            'faculty_id' => '05',
            'semester' => '1',
            'year' => '2557']);
        User::create([
            'id' => '540510795',
            'username' => 'boonchuay_ruk',
            'role_id' => '0001',
            'firstname_th' => 'เจม',
            'firstname_en' => 'Jame',
            'lastname_th' => 'บุญช่วย',
            'lastname_en' => 'Boonchuay',
            'email' => 'boonchuay_ruk@cmu.ac.th',
            'faculty_id' => '05',
            'semester' => '1',
            'year' => '2557']);
        User::create([
            'id' => '000000002',
            'username' => 'tanom_kongjai',
            'role_id' => '1000',
            'firstname_th' => 'ถนอม',
            'firstname_en' => 'Tanom',
            'lastname_th' => 'กองใจ',
            'lastname_en' => 'Kongjai',
            'email' => 'tanom_kongjai@cmu.ac.th',
            'faculty_id' => '05',
            'semester' => '1',
            'year' => '2557']);

        DB::table('ref_roles')->insert(
            [            'id' => '0000',
                'detail' => 'no role',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('ref_roles')->insert(
            [            'id' => '0001',
                'detail' => 'student',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('ref_roles')->insert(
            [            'id' => '0010',
                'detail' => 'ta',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('ref_roles')->insert(
            [            'id' => '0100',
                'detail' => 'student',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('ref_roles')->insert(
            [            'id' => '1000',
                'detail' => 'admin',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('ref_roles')->insert(
            [            'id' => '0011',
                'detail' => 'student,ta',
                'created_at' => $date,
                'updated_at' => $date]);

        DB::table('faculties')->insert([
            'id' => '05',
            'name_th' => 'คณะวิทยาศาสตร์',
            'name_en' => 'Faculty of Science',
            'created_at' => $date,
            'updated_at' => $date]);

    }
}

class CoursesTableSeeder extends Seeder
{
    public function run()
    {
        $date = new \DateTime;
        DB::table('courses')->delete();
        DB::table('course_section')->delete();
        DB::table('course_student')->delete();
        DB::table('course_ta')->delete();

        DB::table('courses')->insert([
            'id' => '204111',
            'name' => 'FUNDAMENTALS OF COMP SC',
            'detail' => '...',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('courses')->insert([
            'id' => '204100',
            'name' => 'IT AND MODERN LIFE',
            'detail' => '...',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('courses')->insert([
            'id' => '204211',
            'name' => 'OBJECT-ORIENTED PROGRAMMING',
            'detail' => '...',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_section')->insert([
            'course_id' => '204100',
            'section' => '001',
            'teacher_id' => '000000001',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_section')->insert([
            'course_id' => '204111',
            'section' => '001',
            'teacher_id' => '000000001',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_section')->insert([
            'course_id' => '204211',
            'section' => '001',
            'teacher_id' => '000000001',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_student')->insert([
            'course_id' => '204111',
            'section' => '001',
            'student_id' => '540510828',
            'status' => ' ',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_student')->insert([
            'course_id' => '204111',
            'section' => '001',
            'student_id' => '540510795',
            'status' => ' ',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('course_ta')->insert([
            'course_id' => '204111',
            'section' => '001',
            'student_id' => '540510828',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
    }
}

class HomeworkTableSeeder extends Seeder
{
    public function run()
    {
        $date = new \DateTime;
        DB::table('homework')->delete();
        DB::table('homework_student')->delete();
        DB::table('homework_types')->delete();

        DB::table('homework')->insert([
            'course_id' => '204111',
            'section' => '001',
            'name' => 'lab01_{id}',
            'type_id' => '002',
            'detail' => 'Homework description goes here.',
            'assign_date' => '2015-06-26 00:00:00',
            'due_date' => '2015-06-30 00:00:00',
            'accept_date' => '2015-07-01 00:00:00',
            'created_by' => '000000001',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('homework')->insert([
            'course_id' => '204100',
            'section' => '001',
            'name' => 'lab01_{id}',
            'type_id' => '003',
            'detail' => 'Homework description goes here.',
            'assign_date' => '2015-06-26 00:00:00',
            'due_date' => '2015-06-30 00:00:00',
            'accept_date' => '2015-07-01 00:00:00',
            'created_by' => '000000001',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);

        DB::table('homework_student')->insert([
            'course_id' => '204111',
            'section' => '001',
            'homework_id'=> 1,
            'homework_name' => 'lab01_540510828.doc',
            'student_id' => '540510828',
            'status' => '1',
            'submitted_at' => '2015-06-26 00:00:00',
            'semester' => '1',
            'year' => '2557',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('homework_types')->insert(
            ['id' => '000',
                'extension' => 'no extension',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('homework_types')->insert(
            ['id' => '001',
                'extension' => 'paper homework',
                'created_at' => $date,
                'updated_at' => $date]);
        DB::table('homework_types')->insert(
            ['id' => '002',
            'extension' => '.doc,.docx',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('homework_types')->insert(['id' => '003',
            'extension' => '.xls,.xlsx',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('homework_types')->insert(['id' => '004',
            'extension' => '.c,.cpp',
            'created_at' => $date,
            'updated_at' => $date]);
    }
}

class CurrentSemesterYearTableSeeder extends Seeder
{
    public function run()
    {
        $date = new \DateTime;
        DB::table('semester_year')->insert([
            'semester' => '1',
            'year' => '2557',
            'use' => '1',
            'created_at' => $date,
            'updated_at' => $date]);
        DB::table('semester_year')->insert([
            'semester' => '2',
            'year' => '2556',
            'use' => '0',
            'created_at' => $date,
            'updated_at' => $date]);
    }
}



