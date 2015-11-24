<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Course_Ta extends Model {

    protected $table = 'course_ta';

    protected $appends = ['course_name'];
    protected $fillable = ['course_id','section', 'student_id', 'semester', 'year'];

    /**
     * Accessor Function
     */
    public function getCourseNameAttribute()
    {
        $local_course_name = DB::select('SELECT name FROM courses where id=? ', array( $this->attributes['course_id'] ));
        return $local_course_name[0]->name;
    }

    /**
     * @param $query
     * @return mixed
     *
     * @Sample usage $courses = Course_Ta::assist(student_id,1,2557)->orderBy('created_at')->get();
     * orderBy('created_at') is optional
     */
    public function scopeAssist($query,$a_id,$semester,$year)
    {
        return $query->where('semester','=',$semester)->where('year','=',$year)->where('student_id','=',$a_id);
    }
}
