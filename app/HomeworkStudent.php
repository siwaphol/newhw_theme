<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeworkStudent extends Model {

    protected $table = 'homework_student';

    protected $fillable = ['course_id', 'section', 'homework_id',
        'homework_name', 'student_id', 'status', 'submitted_at','semester','year'];
    protected $dates = ['submitted_at'];

	public function scopeCurrentSemester($query)
	{
		return $query->where('semester', '=', \Session::get('semester'))
		             ->where('year', '=', \Session::get('year'));
	}
}
