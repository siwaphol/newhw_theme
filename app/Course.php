<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    protected $table = 'courses';

    protected $fillable = ['id', 'name','detail'];

    public $incrementing = false;

    protected $primaryKey = 'id';

//    public function teacher(){
//        return $this->belongsTo('App\Teacher');
//    }

    /**
     * Get the students associated with the given course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany('App\User', 'course_student', 'course_id', 'student_id')
            ->withTimestamps()
            ->withPivot(['section','student_id','status','semester','year']);
    }

    public function users(){
        return $this->belongsToMany('App\User', 'course_student', 'course_id', 'student_id')->withTimestamps();
    }

    public function teachers(){
        return $this->belongsToMany('App\User', 'course_section', 'course_id', 'teacher_id')
            ->withTimestamps()
            ->withPivot(['section','teacher_id','semester','year']);
    }

    public function assistants(){
        return $this->belongsToMany('App\User', 'course_ta', 'course_id', 'student_id')
            ->withTimestamps()
            ->withPivot(['section','student_id','semester','year']);
    }

}
