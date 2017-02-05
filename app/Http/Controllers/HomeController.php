<?php namespace App\Http\Controllers;

//use App\Http\Controllers\Auth;
use App\Course;
use App\Course_Section;
use App\Course_Student;
use App\Course_Ta;
use App\Homework;
use Auth;
use Request;
use Session;
use DB;
use App\User;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function info()
    {
        return view('info/info');
    }

    public function assign()
    {
        return view('assign', array('course' => '204219', 'section' => '001'));
    }

    public function course()
    {
        $model = Course::all();

        return view('course', compact('model'));
    }

    /**
     * @return array
     */
    public function semester()
    {
        $model = Request::all();
        Session::put('semester', Request::get('semester'));
        Session::put('year', Request::get('year'));
        Session::forget('course_list');
        $sql = DB::select('select * from course_section where semester=? and year=? ORDER by course_id', array(Session::get('semester'), Session::get('year')));
        $course_list_str = "";
        foreach ($sql as $course) {
            if ($course_list_str === '') {
                $course_list_str = $course->course_id;
            } else {
                $course_list_str = $course_list_str . ',' . $course->course_id;
            }
        }
        Session::put('course_list', $course_list_str);
        return new RedirectResponse(url('home'));
    }

    public function firstpage()
    {
        if(Auth::user()->isAdmin()){
            $page_name = "Main";
            $sub_name = "Overview";
        }else{
            $page_name = "My Courses";
            $sub_name = "Overview";
        }

        $assist = DB::select('select * from course_ta cs');
        if (\Auth::user()->isAdmin()) {
            $result = Course_Section::semesterAndYear(Session::get('semester'),Session::get('year'))->orderBy('course_id','section')->get();
        }
        if (\Auth::user()->isTeacher()) {
            $result = Course_Section::teaching(Auth::user()->id,Session::get('semester'), Session::get('year'))->orderBy('course_id','section')->get();
        }
        if (\Auth::user()->isTa()) {
            $result = Course_Ta::assist(Auth::user()->id,Session::get('semester'), Session::get('year'))->orderBy('course_id','section')->get();
        }
        if (\Auth::user()->isStudent()) {
            $result = Course_Student::enroll(Auth::user()->id,Session::get('semester'), Session::get('year'))->get();
        }
        if (\Auth::user()->isStudentandTa()) {
            $result = Course_Student::enroll(Auth::user()->id,Session::get('semester'), Session::get('year'))->get();

            $assist = Course_Ta::assist(Auth::user()->id,Session::get('semester'), Session::get('year'))->get();
        }

        return view('home.index', compact('result', 'assist', 'page_name', 'sub_name'));
    }

    public function preview()
    {
        $course_no = $_GET['course'];
        $section = $_GET['sec'];
        Session::put('course_no', $course_no);
        Session::put('section', $section);
        $currentSemester = Session::get('semester');
        $currentYear = Session::get('year');

//        $teachers = User::teacher()->with(['teachcourses'=>function($q) use($course_no,$section,$currentSemester,$currentYear){
//            $q->where('course_section.course_id','=', $course_no)
//            ->where('course_section.section','=', section);
//        }])->get(['id','firstname_en','lastname_en']);

        $courseWithTeaAssist = Course::with(['teachers'=>function($q) use($section,$currentSemester,$currentYear){
            $q->where('course_section.section','=',$section)
                ->where('course_section.semester','=',$currentSemester)
                ->where('course_section.year','=',$currentYear);
        }])
            ->with(['assistants'=>function($q) use($section,$currentSemester,$currentYear) {
            $q->where('course_ta.section', '=', $section)
                ->where('course_ta.semester', '=', $currentSemester)
                ->where('course_ta.year', '=', $currentYear);
        }])->where('id','=',$course_no)->first();
//        dd($teachers->toJson());
//        $teachers = DB::select('select cs.id as id,tea.id as teacher_id,tea.firstname_en as firstname,tea.lastname_en as lastname
//                            from course_section cs
//                            LEFT  join users tea on cs.teacher_id=tea.id
//                            where cs.semester=? and cs.year=? and cs.course_id=? and cs.section=?', array(Session::get('semester'), Session::get('year'), $course_no, $section));

//        $ta = DB::select('select ct.id as id,tea.id as ta_id,tea.firstname_th as firstname,tea.lastname_th as lastname
//                            from course_ta ct
//                            LEFT  join users tea on ct.student_id=tea.id
//                            where ct.semester=? and ct.year=? and ct.course_id=? and ct.section=?', array(Session::get('semester'), Session::get('year'), $course_no, $section));

        if (Auth::user()->isAdmin() || Auth::user()->isTeacher()) {
//            $student = DB::select('select * from users where role_id=0001');
            $student = User::student()->get();
        }
        else if (Auth::user()->isStudent()) {
            $student = User::find(Auth::user()->id);
//            $student = DB::select('select * from users where id=?', array(Auth::user()->id));
        }

        //การบ้านทั้งหมดที่นักเรียนต้องส่ง / All homework that should be submitted by students
        $homework = Homework::fromCourseAndSection($course_no,$section,Session::get('semester'),Session::get('year'))
            ->orderBy('due_date')
            ->get();

        if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->isTa() || Auth::user()->isStudentandTa()) {
            $sent = DB::select('select cs.student_id as id,stu.firstname_th,stu.lastname_th,cs.status as status,
                        stu.firstname_en, stu.lastname_en
                            from course_student cs
                            left join users stu 
                            on cs.student_id=stu.id
                           where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=?',
                array($course_no, $section, Session::get('semester'), Session::get('year')));
        }
        else if (Auth::user()->isStudent()) {
            $currentStudentId = Auth::user()->id;

            $sqlStr = "SELECT cs.course_id,cs.section,cs.student_id,cs.semester,cs.year
            ,h.id ,h.name,h.type_id,h.detail,h.assign_date,h.due_date,h.accept_date
            ,hs.homework_id,hs.homework_name,hs.status,hs.submitted_at,hs.path
            ,ht.extension
            FROM course_student cs
            LEFT JOIN homework h
            ON cs.course_id=h.course_id and cs.section=h.section and h.semester='{$currentSemester}' and h.year='{$currentYear}'
            LEFT JOIN homework_student hs
            ON h.id=hs.homework_id
            LEFT JOIN homework_types ht 
            ON h.type_id=ht.id
            WHERE 
            cs.course_id='{$course_no}'
            and cs.section='{$section}' 
            and cs.semester='{$currentSemester}'
            and cs.year='{$currentYear}'
            and cs.student_id='{$currentStudentId}'
            ";

            $sent= DB::select($sqlStr);

            foreach ($sent as $aHomework){
                if(!is_null($aHomework)){
                    switch ($aHomework->status){
                        case 1:
                            $aHomework->{"status_text"} = "OK";
                            break;
                        case 2:
                            $aHomework->{"status_text"} = "LATE";
                            break;
                        case 3:
                            $aHomework->{"status_text"} = "!!!";
                            break;
                    }
                }

                $aHomework->name = str_replace("{id}",$currentStudentId,$aHomework->name);
                $extensions = explode(",",$aHomework->extension );
                $aHomework->{"expected_name"} = "";
                foreach ($extensions as $ext){
                    $aHomework->{"expected_name"} .= $aHomework->name . $ext . ",";
                }
                $aHomework->{"expected_name"} = rtrim($aHomework->{"expected_name"}, ",");
            }
//            dd($sent);

//            $sent = $sent->students->first();
//            $sent = DB::select('select cs.student_id as studentid,stu.firstname_th as firstname,stu.lastname_th as lastname,cs.status as status
//                            from course_student cs
//                            left join users stu on cs.student_id=stu.id
//                           where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=? and cs.student_id=?',
//                array($course_no, $section, Session::get('semester'), Session::get('year'), Auth::user()->id));
        }
//        dd($sent->toJson());

        $removeHeader = true;

        if(auth()->user()->isStudent())
            return view('students.homework.index', compact('courseWithTeaAssist','student','sent','homework','removeHeader','course_no','section'));

//        return view('home.preview', compact('teachers', 'ta', 'student', 'homework', 'sent', 'removeHeader','teachersAndTA','course_no','section'))->with('course', array('co' => $course_no, 'sec' => $section));
        return view('admin.dashboard', compact('courseWithTeaAssist','student','sent','homework','removeHeader','course_no','section'));
    }

//    public function preview1()
//    {
//        $course = $_GET['course'];
//        $sec = $_GET['sec'];
//
//        $teachers = DB::select('select cs.id as id,tea.id as teacher_id,tea.firstname_en as firstname,tea.lastname_en as lastname
//                            from course_section cs
//                            LEFT  join users tea on cs.teacher_id=tea.id
//                            where cs.semester=? and cs.year=? and cs.course_id=? and cs.section=?', array(Session::get('semester'), Session::get('year'), $course, $sec));
//        $ta = DB::select('select ct.id as id,tea.id as ta_id,tea.firstname_th as firstname,tea.lastname_th as lastname
//                            from course_ta ct
//                            LEFT  join users tea on ct.student_id=tea.id
//                            where ct.semester=? and ct.year=? and ct.course_id=? and ct.section=?', array(Session::get('semester'), Session::get('year'), $course, $sec));
//
//        if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->isTa()) {
//            $student = DB::select('select * from users where role_id=0001');
//        }
//        if (Auth::user()->isStudent()) {
//            $student = DB::select('select * from users where id=?', array(Auth::user()->id));
//        }
//        $homework = DB::select('select * from homework where course_id=? and section=?
//                                and semester=? and year=?', array($course, $sec, Session::get('semester'), Session::get('year')));
//        if (Auth::user()->isAdmin() || Auth::user()->isTeacher()) {
//            $sent = DB::select('select cs.student_id as studentid,stu.firstname_th as firstname,stu.lastname_th as lastname,cs.status as status
//                            from course_student cs
//                            left join users stu on cs.student_id=stu.id
//                           where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=?',
//                array($course, $sec, Session::get('semester'), Session::get('year')));
//        }
//        if (Auth::user()->isStudent() || Auth::user()->isStudentandTa()) {
//            $student = DB::select('select * from users where id=?', array(Auth::user()->id));
//            if (Auth::user()->isStudent() || Auth::user()->isStudentandTa()) {
//                $sent = DB::select('select cs.student_id as studentid,stu.firstname_th as firstname,stu.lastname_th as lastname,cs.status as status
//                            from course_student cs
//                            left join users stu on cs.student_id=stu.id
//                           where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=? and cs.student_id=?',
//                    array($course, $sec, Session::get('semester'), Session::get('year'), Auth::user()->id));
//            }
//
//            return view('home.previewdownload', compact('teachers', 'ta', 'student', 'homework', 'sent'))->with('course', array('co' => $course, 'sec' => $sec));
//
//        }
//    }

    public function exportzip()
    {
        $files = glob('public/files/*');
        Zipper::make('public/test.zip')->add($files);
    }


}
