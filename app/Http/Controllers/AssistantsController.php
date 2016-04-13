<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Assistants;

use Carbon\Carbon;
use DB;
use App\Http\Requests\AsistantRequest;
use App\Asistant;
use App\Semesteryears;
use Session;
class AssistantsController extends Controller {

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
		return view('assistants.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{   $course = $_GET['course'];
        $sec = $_GET['sec'];

		return view('assistants.create')->with('cosec',array('course'=>$course,'sec'=>$sec));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AsistantRequest $request)
	{
        $course=$request->get('courseId');
        $sec=$request->get('sectionId');
        $ta_id=$request->get('taId');
        $assistant=DB::select('select * from course_ta where course_id=? and section=? and student_id=? and semester=? and year=?
                                ',array($course,$sec,$ta_id,Session::get('semester'),Session::get('year')));
        $count=count($assistant);

        if($count>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'รหัสนักศึกษา '.$ta_id.' ซ้ำ']);

        }

        $asis=new Asistant();
        $asis->course_id=$course;
        $asis->section=$sec;
        $asis->student_id=$ta_id;
        $asis->semester=Session::get('semester');
        $asis->year=Session::get('year');
        $asis->save();
        $check=DB::select('select * from users where id=? and role_id=0001 ',array($ta_id));
        if(count($check)>0){
            $update=DB::update('update users set role_id=0011 where id=?',array($ta_id));
        }
        if(count($check)>0){
            $insert=DB::insert('insert into users (id,role_id) values(?,0010)',array($ta_id));
        }

        return redirect()->action('HomeController@preview',array('course'=>$course,'sec'=>$sec));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $assistant=DB::select('select ass.id as id,ta.id as student_id, ta.username as tausername,ta.firstname_th as firstname,ta.lastname_th as lastname ,ass.course_id as courseid,ass.section as sectionid
                                from course_ta ass
                                left join users ta on ass.student_id=ta.id
                                 where ta.username=? and ass.semester=? and ass.year=?',array($id,Session::get('semester'),Session::get('year')));
		//$assistant = Assistants::findOrFail($id);
		return view('assistants.show')->with('assistant',$assistant);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
        $course=$_GET['course'];
        $sec=$_GET['sec'];
        $ta_username=$_GET['username'];
        $assistant=DB::select('select st.course_id as course_id
                                ,st.id as id
                                ,st.section as section
                                ,ta.id as student_id
                                ,ta.firstname_th as firstname
                                ,ta.lastname_th as lastname
                                from course_ta st
                                left join semester_year sy on st.semester=sy.semester and st.year=sy.year
                                left join users ta on st.student_id=ta.id
                                where st.course_id=? and st.section=? and ta.username=? and sy.use=1',array($course,$sec,$ta_username));
		//$assistant = Assistants::findOrFail($id);
		return view('assistants.edit', compact('assistant'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
        $course_id=$_POST['course_id'];
        $section=$_POST['section'];
        $student_id=$_POST['student_id'];
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		$assistant = Assistants::findOrFail($id);
		$assistant->update($request->all());
        return redirect()->action('HomeController@preview',array('course'=>$course_id,'sec'=>$section));
		//return redirect('assistants');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
        $course=$_POST['course'];
        $sec=$_POST['sec'];
        $ta_id=$_POST['id'];
		$result=DB::delete('delete from course_ta where course_id=? and section=? and student_id=?',array($course,$sec,$ta_id));
		//return redirect('assistants');
        return redirect()->action('HomeController@preview',array('course'=>$course,'sec'=>$sec));
	}
    public function showlist()
    {
        $course = $_GET['ddlCourse'];
        $sec = $_GET['ddlSection'];
        $cours=array('co'=>$course,'sec'=>$sec);
        //return $cours;
        return view('assistants.showlist')->with('course',$cours);
    }
}