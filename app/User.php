<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use DB;
use Session;
use yajra\Datatables\Datatables;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'id','username', 'role_id','firstname_th','firstname_en','lastname_th',
                            'lastname_en','email','faculty_id','semester','year'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function teachcourses(){
        return $this->belongsToMany('App\Course', 'course_section', 'teacher_id', 'course_id')->withTimestamps();
    }

    public function teaching()
    {
        return $this->hasMany('App\Course_Section','teacher_id');
    }

    public function submittedHomework()
    {
        return $this->hasMany('App\HomeworkStudent','student_id');
    }

    public function teachingCourseSection($course_no,$section,$semester,$year)
    {
        $all_teach_course = $this->hasMany('App\Course_Section','teacher_id');
        return $all_teach_course->where('course_id','=',$course_no)
            ->where('section','=',$section)
            ->where('semester','=',$semester)
            ->where('year','=',$year)
            ->get();
    }

    public function getHomeworkWithStatus($course_id,$section)
    {
        $homework_list = new Collection();

        $query_hw_template = DB::select("SELECT id,name FROM homework WHERE course_id = ?
            AND (section = ? OR TRIM(section) = '')",array($course_id,$section));

        $query_hw_student = DB::select("SELECT homework_name,status,homework_id FROM homework_student
            WHERE course_id = ? AND section = ? AND semester = ? AND year =? AND student_id = ?",array($course_id,$section,Session::get('semester'),Session::get('year'),\Auth::user()->id));

        foreach($query_hw_template as $homework)
        {
            $found = false;
            foreach($query_hw_student as $sent_homework)
            {
                if($homework->id === $sent_homework->homework_id)
                {
                    $homework_list->push([
                        'name'         => $sent_homework->homework_name,
                        'status'       => 'OK'
                    ]);
                    $found = true;
                }
                if($found){
                    break;
                }
            }
            if(!$found){
                $homework_list->push([
                    'name'         => $homework->name,
                    'status'       => 'Waiting'
                ]);
            }

        }

        return Datatables::of($homework_list)->make(true);
    }

    /**
     * @param $query
     * @return mixed
     *
     * @Sample usage $users = User::admin()->orderBy('created_at')->get();
     */
    public function scopeAdmin($query)
    {
        return $query->where('role_id', 'like', '1___');
    }
    public function scopeTeacher($query)
    {
        return $query->where('role_id', 'like', '_1__');
    }
    public function scopeTa($query)
    {
        return $query->where('role_id', 'like', '__1_');
    }
    public function scopeStudent($query)
    {
        return $query->where('role_id', 'like', '___1');
    }

    public function scopeLastEmployee($query)
    {
        return $query->where('id', '<' , '000010000')->orderBy('id','desc')->first();
    }
    /**
     * Accessor Function
     */
    public function getFirstNameEnAttribute()
    {
        return ucfirst($this->attributes['firstname_en']);
    }
    /**
     * Custom functions
     */
    public function isAdmin()
    {
        return substr($this->attributes['role_id'],0,1) == '1';
    }
    public function isTeacher()
    {
        return substr($this->attributes['role_id'],1,1) == '1';
    }
    public function isTa()
    {
        //return substr($this->attributes['role_id'],2,1) == '1';
        return $this->role_id== '0010';
    }
    public function isStudent()
    {
        //return substr($this->attributes['role_id'],3,1) == '1';
        return $this->role_id== '0001';
    }
    public function isStudentandTa()
    {
        //return substr($this->attributes['role_id'],2,2) == '11';
        return $this->role_id== '0011';
    }
    public function role()
    {
        if($this->isAdmin()){
            return "Admin";
        }else if($this->isTeacher()){
            return "Teacher";
        }else if($this->isTa()){
            return "Ta";
        }else if($this->isStudent()){
            return "Student";
        }
        else if($this->isStudentandTa()){
            return "Ta,Student";
        }
        return "";
    }

    public function getCourseList(){
        if($this->isAdmin()){

            $course_list = DB::select('SELECT DISTINCT course_id FROM course_section where semester=? and year=?',array(Session::get('semester'),Session::get('year')));
            return $course_list;
        }else if($this->isTeacher()){
            $course_list = DB::select('SELECT DISTINCT course_id FROM course_section WHERE teacher_id = ? and semester=? and year=?',array($this->attributes['id'],Session::get('semester'),Session::get('year')));
            return $course_list;
        }
    }



}
