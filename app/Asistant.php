<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistant extends Model {

	//
    protected $table = 'course_ta';

    protected $fillable = ['id','course_id','section', 'student_id'];

    protected $primaryKey = 'id';

    public $incrementing = true;
}
