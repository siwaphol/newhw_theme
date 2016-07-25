<?php namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Homework1s;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use Zipper;
use ZipArchive;
use App\HomeworkStudent;

class Homework1Controller extends Controller {

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
        $course=$_GET['course'];
        $sec=$_GET['sec'];
        $homework1s=DB::select('select * from homework where course_id=? and section=? and semester=? and year=? ',array($course,$sec,Session::get('semester'),Session::get('year')));
		//$homework1s = Homework1s::latest()->get();
		return view('homework1.index', compact('homework1s'))->with('course',array('course'=>$course,'sec'=>$sec));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $course=$_GET['course'];
        $sec=$_GET['sec'];
		return view('homework1.create')->with('course',array('course'=>$course,'sec'=>$sec));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
     $course=$request->get('course_id');
        $section=$request->get('section');

        $name=$request->get('name');
        $flietype=$request->get('type_id');
        $detail=$request->get('detail');
        $sub_folder=$request->get('sub_folder');
        $due_date=$request->get('due_date');
        $accdept_date=$request->get('accept_date');
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		//Homework1s::create($request->all());
        $assistant=DB::select('select * from homework where course_id=? and section=? and name=? and type_id=? and semester=? and year=?
                                ',array($course,$section,$name,$flietype,Session::get('semester'),Session::get('year')));
        $count=count($assistant);

        if($count>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'Duplicate Homework']);

        }
        $hw=new Homework1s();
        $hw->course_id=$course;
        $hw->section=$section;
        $hw->name=$name;
        $hw->type_id=$flietype;
        $hw->detail=$detail;
        $hw->sub_folder=$sub_folder;
        $hw->due_date=$due_date;
        $hw->accept_date=$accdept_date;

//        $hw->assign_date=now();
        $hw->semester=Session::get('semester');
        $hw->year=Session::get('year');
        $hw->save();
//        save=$_POST['course_id'];
//        $section=$_POST['section'];
//        dd($course);
//        $name=$_POST['name'];
//        $flietype=$_POST['type_id'];
//        $detail=$_POST['detail'];
//        $sub_folder=$_POST['sub_folder'];
//        $due_date=$_POST['due_date'];
//        $accdept_date=$_POST['accept_date'];
		//return redirect('homework')->with('course',array('course'=>$course,'sec'=>$section));
        return redirect()->action('Homework1Controller@index',array('course'=>$course,'sec'=>$section));
       // $homework1s=DB::select('select * from homework where course_id=? and section=? and semester=? and year=? ',array($course,$section,Session::get('semester'),Session::get('year')));
        //$homework1s = Homework1s::latest()->get();
       // return view('homework1.index', compact('homework1s'))->with('course',array('course'=>$course,'sec'=>$sec));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$homework1 = Homework1s::findOrFail($id);
		return view('homework1.show', compact('homework1'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$homework1 = Homework1s::findOrFail($id);
		return view('homework1.edit', compact('homework1'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		$homework1 = Homework1s::findOrFail($id);
		$homework1->update($request->all());
		return redirect('homework1');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Homework1s::destroy($id);
		return redirect('homework1');
	}

    public function exportzip(){
        $course=$_GET['course'];
        $sec=$_GET['sec'];
        $path1=$_GET['path'];
        $type=$_GET['type'];
      return view('homework1.download')->with('course',array('course'=>$course,'sec'=>$sec,'path'=>$path1,'type'=>$type));
    }
    public function editstatus(){
        $course=$_POST['course'];
        $sec=$_POST['sec'];
        $hwid=$_POST['hw'];
        $studentid=$_POST['stu'];
        $status=$_POST['status'];
       // dd($studentid);
        $sql=DB::select('select id from homework_student where homework_id=? and course_id=? and section=? and student_id=?
                          and semester=? and year=? ',array($hwid,$course,$sec,$studentid,Session::get('semester'),Session::get('year')));
        //dd($sql);
        if(count($sql)>0){
//            $update=DB::update('update homework_student set status=? where homework_id=? and course_id=? and section=? and student_id=?
//                          and semester=? and year=? ',array($status,$hwid,$course,$sec,$studentid,Session::get('semester'),Session::get('year')));
                        //$update=DB::update('update homework_student set status=? where id=? ',array($status,$sql[0]->id));
            $hw=HomeworkStudent::findorfail($sql[0]->id);
            $hw->status=$status;
            $hw->save();

        }else{
            return redirect()->back()
                ->withErrors(['duplicate' => 'นักศึกษายังไม่ได้ส่งการบ้าน']);
        }
        return redirect()->action('HomeController@preview',array('course'=>$course,'sec'=>$sec));


    }

	public function testPost(Request $request)
	{
		dd($request);
	}

    public function getUploadView($id)
    {
        $section = Session::get('section');
        $currentSemester = Session::get('semester');
        $currentYear = Session::get('year');
        $course_no = Session::get('course_no');

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
        Session::put('course_name', $courseWithTeaAssist->name);

        return view('students.homework.upload', compact('courseWithTeaAssist','course_no','section'));
	}

}