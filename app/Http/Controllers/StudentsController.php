<?php namespace App\Http\Controllers;

use App\Course_Section;
use App\Http\Requests\Formstudents;
use App\Http\Controllers\Controller;

use App\Students;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use Excel;
class StudentsController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$students =DB::select('select * from users WHERE  role_id=0001');
		//return view('students.index', compact('students'));
        return view('students.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)

	{
        $course=DB::select('select * from course_section  where id=?',array($id));
		return view('students.create',compact('course'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Formstudents $request)
	{
		$course_id=$request->get('course_id');
        $section=$request->get('section');
        $student_id=$request->get('student_id');
        $status=$request->get('status');
        $check=DB::select('select * from course_student where course_id=? and section=? and student_id=?
                            and semester=? and year=?',array($course_id,$section,$student_id,Session::get('semester'),Session::get('year')));
        if(count($check)>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'รหัสนักศึกษา '.$student_id.' ซ้ำ']);
        }
        $insert=DB::insert('insert into course_student (course_id,section,student_id,status,semester,year) VALUES (?,?,?,?,?,?)',array($course_id,$section,$student_id,$status,Session::get('semester'),Session::get('year')));

		//return redirect('students/showlist');
        //return view('students.showlist')->with('course',array('co'=>$course_id,'sec'=>$section));
        return redirect()->action('HomeController@preview',array('course'=>$course_id,'sec'=>$section));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
        $id=$_GET['id'];
        $course=$_GET['course'];
        $sec=$_GET['sec'];
		//$student = Student::findOrFail($id);
        $student=DB::select('select cs.student_id as student_id
                              ,stu.firstname_th as firstname
                              ,stu.lastname_th as lastname
                              ,stu.email as email
                              ,fac.name_th as faculty
                              ,cs.status as status
                              ,stu.role_id as role_id
                              from course_student cs
                              left join users stu on cs.student_id=stu.id
                              left join faculties fac on stu.faculty_id=fac.id
                               where (stu.role_id=0001 OR stu.role_id=0011) and cs.student_id=?
                               and cs.semester=? and cs.year=?',array($id,Session::get('semester'),Session::get('year')));
		return view('students.show', compact('student'))->with('course',array('co'=>$course,'sec'=>$sec));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$student=DB::select('select * from users where id=?',array($id));
		return view('students.edit', compact('student'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Formstudents $request)
	{
        $id=$request->get('id');
        $username=$request->get('username');
        $firstname_th=$request->get('firstname_th');
        $firstname_en=$request->get('firstname_en');
        $lastname_th=$request->get('lastname_th');
        $lastname_en=$request->get('lastname_en');
        $email=$request->get('email');
        $update=DB::update('update users set username=?,firstname_th=?,firstname_en=?,lastname_th=?,lastname_en=?,email=? where id=?',array($username,$firstname_th,$firstname_en,$lastname_th,$lastname_en,$email,$id));
		return redirect('students');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{   $id=$_POST['id'];
        $course=$_POST['course'];
        $sec=$_POST['sec'];
		//Students::destroy($id);
//        $result1=DB::delete('delete from users where id=?',array($id));
        $result=DB::delete('delete from course_student WHERE course_id=? and section=? and student_id=?
                            and semester=? and year=?',array($course,$sec,$id,Session::get('semester'),Session::get('year')));
        //return redirect()->back();
        return redirect()->action('HomeController@preview',array('course'=>$course,'sec'=>$sec));
		//return redirect('students');
	}
    public function import()
    {

        return view('students.selectcourse_section');
    }
    public function manualimport()
    {

        return view('students.selectmanualcourse_section');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert()
    {
        $course = $_GET['ddlCourse'];
        $sec = $_GET['ddlSection'];
        $cours=array('co'=>$course,'sec'=>$sec);
        //return $cours;
        return view('students.insert')->with('cours',$cours);
    }
    public function showlist()
    {
        $course = $_POST['ddlCourse'];
        $sec = $_POST['ddlSection'];
        $cours=array('co'=>$course,'sec'=>$sec);
        //return $cours;
        return view('students.showlist')->with('course',$cours);
    }
    public function export(){
        $course=$_GET['course'];
        $sec=$_GET['sec'];

        return view('students.export')->with('course',array('co'=>$course,'sec'=>$sec));
    }
    public function manualinsert()
    {
        $course = $_POST['ddlCourse'];
        $sec = $_POST['ddlSection'];
        $fileupload_name=$_FILES['fileupload']['name'];
        $cours=array('co'=>$course,'sec'=>$sec,'fileupload'=>$fileupload_name);
        //return $cours;
        return view('students.manualinsert')->with('cours',$cours);
    }
    public function autoimport()
    {
        return view('students.autoinsert');
    }

    public function auto_import_ajax()
    {
        //for test only
        $fileupload_name = "https://www3.reg.cmu.ac.th/regist158/public/stdtotal_xlsx.php?var=maxregist&COURSENO=204100&SECLEC=001&SECLAB=000&border=1&mime=xlsx&ctype=&";
        //end for test only
        $fileupload='../temp/file.xlsx';
        $result = null;
        //get semester and year from Session
        $semester = Session::get('semester');
        $year = Session::get('year');
        $year_2char = substr(Session::get('year'),-2);
        //nong for test only
        $semester = '1';
        $year = '2557';
        $year_2char = '57';
        //end nong for test only
        //get all sections with current semester and year
        $all_course_sections = Course_Section::semesterAndYear($semester,$year)->get();

        $course_no = '';
        $seclec = '';
        foreach($all_course_sections as $aSection){
            $seclab = $aSection->section === '000' ? '001':'000';
            $xlsx_url = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year_2char.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$aSection->course_id.'&SECLEC='.$aSection->section.'&SECLAB='.$seclab.'&border=1&mime=xlsx&ctype=&';
            if(copy($fileupload_name,$fileupload)){
                $result = Excel::load($fileupload, function($reader) {
                })->get();
                dd($result->toArray());
//            $result->dd();

            }
        }

        return null; //this will return json
    }
    public function auto_import_ajax2($course_no, $section){

    }
    public function selectexcel(){
        $course = $_GET['ddlCourse'];
        $sec = $_GET['ddlSection'];
        return view('students.selectexcel')->with('course',array('co'=>$course,'sec'=>$sec));
    }
    public function getStudentsXLSX($semester, $year)
    {
        $year_2char = substr($year,-2);
        $all_course_sections = Course_Section::semesterAndYear($semester,$year)
        ->distinct()
        ->groupBy('course_id')
        ->groupBy('section')
        ->get();
        $basePath= storage_path('temp/');

        foreach($all_course_sections as $aSection){
            
        }
    }
    //TODO-nong this one is for test to download all excel file for each course section to server, Never use this in production
    public function downloadAllExcelForCourseSection($semester, $year)
    {
        $year_2char = substr($year,-2);
        $all_course_sections = Course_Section::semesterAndYear($semester,$year)
        ->distinct()
        ->groupBy('course_id')
        ->groupBy('section')
        ->get();
        $basePath= storage_path('temp/');
        foreach($all_course_sections as $aSection){
            $seclab = $aSection->section === '000' ? '001':'000';
            $xlsx_url = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year_2char.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$aSection->course_id.'&SECLEC='.$aSection->section.'&SECLAB='.$seclab.'&border=1&mime=xlsx&ctype=&';
            $fileupload = $basePath . $aSection->course_id . '_' . $aSection->section . '.xlsx';
            if(copy($xlsx_url,$fileupload)){
                echo "complete ". $fileupload ." </br>";
            }
        }
    }
}