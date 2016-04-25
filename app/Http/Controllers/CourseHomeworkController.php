<?php namespace App\Http\Controllers;

use App\Course_Section;
use App\Homework;
use App\HomeworkFolder;
use App\HomeworkStudent;
use App\HomeworkType;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Course;
use DB;
use Session;
use Input;
use Validator;
use Response;
use Log;
use File;

class CourseHomeworkController extends Controller {

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
		//
	}

    public function create2($course_id)
    {
        $page_name = "Create Homework";
        $sub_name = "" . $course_id;

        $temp = HomeworkType::all();
        foreach ($temp as $hwType) {
            $file_types[$hwType['id']] = $hwType['extension'];
        }

        // dd($file_types);

        return view('homework_assignment.create', compact('page_name', 'sub_name', 'file_types'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($course_id)
	{
        $section_list = DB::select("SELECT section FROM course_section WHERE course_id = ?",[$course_id]);
        $filetype_list = DB::select("SELECT id,extension FROM homework_types");

        return view('teacherhomework.createhomework2',['course_id'=>$course_id,'section_list'=>$section_list,'filetype_list'=>$filetype_list]);
	}

    public function create_post($course_id){

        if(\Request::ajax()) {
            if(\Input::get('method') == 'add'){
                if(\Input::has('new_file')) {
                    $params = array();
                    parse_str($_POST['new_file'], $params);

                    $homework_template = new Homework;
                    $homework_template->course_id = $course_id;
                    $homework_template->section = $params['section'];
                    $homework_template->name = $params['homeworkname'];
                    $homework_template->type_id = $params['filetype'];
                    $homework_template->detail = $params['filedetail'];
                    $homework_template->path = '.';
                    $date = new \DateTime;
                    $homework_template->assign_date = $date;
                    $homework_template->due_date = $this->convertDatepickerFormat($params['dueDate']);
                    $homework_template->accept_date = $this->convertDatepickerFormat($params['acceptUntil']);
                    $homework_template->created_by = \Auth::user()->id;
                    $homework_template->semester = \Session::get('semester');
                    $homework_template->year = \Session::get('year');
                    $saved = $homework_template->save();

                    if (!$saved) {
                        return "error";
                    }
                    return "success";
                }else if(\Input::has('new_folder')){
                    $params = array();
                    parse_str($_POST['new_folder'], $params);

                    $hw_folder_template = new HomeworkFolder;
                    $hw_folder_template->course_id = $course_id;
                    $hw_folder_template->section = $params['folderSection'];
                    $hw_folder_template->name = $params['folderName'];
                    $hw_folder_template->path = '.';
                    $hw_folder_template->semester = \Session::get('semester');
                    $hw_folder_template->year = \Session::get('year');
                    $saved = $hw_folder_template->save();

                    if (!$saved) {
                        return "error";
                    }
                    return "success";
                }
            }else if(\Input::get('method') == 'edit'){

            }
        }
        return "error";
    }
    public function create_get_long($course_id,$path){
        $_GET['path'] = $path;
        return view('teacherhomework.createhomework2',['course_id'=>$course_id]);
    }
    public function create_post_long($course_id,$path){
        if(\Request::ajax()) {
            if(\Input::has('new_file')) {
                $params = array();
                parse_str($_POST['new_file'], $params);

                $homework_template = new Homework;
                $homework_template->course_id = $course_id;
                $homework_template->section = $params['section'];
                $homework_template->name = $params['homeworkname'];
                $homework_template->type_id = $params['filetype'];
                $homework_template->detail = $params['filedetail'];
                $homework_template->path = './' . $path;
                $date = new \DateTime;
                $homework_template->assign_date = $date;
                $homework_template->due_date = $this->convertDatepickerFormat($params['dueDate']);
                $homework_template->accept_date = $this->convertDatepickerFormat($params['acceptUntil']);
                $homework_template->created_by = \Auth::user()->id;
                $homework_template->semester = \Session::get('semester');
                $homework_template->year = \Session::get('year');
                $saved = $homework_template->save();

                if(!$saved){
                    return "error";
                }
                return "success";
            }else if(\Input::has('new_folder')){
                $params = array();
                parse_str($_POST['new_folder'], $params);

                $hw_folder_template = new HomeworkFolder;
                $hw_folder_template->course_id = $course_id;
                $hw_folder_template->section = $params['folderSection'];
                $hw_folder_template->name = $params['folderName'];
                $hw_folder_template->path = './' . $path;
                $hw_folder_template->semester = \Session::get('semester');
                $hw_folder_template->year = \Session::get('year');
                $saved = $hw_folder_template->save();

                if (!$saved) {
                    return "error";
                }
                return "success";
            }
        }
        return "error";
    }
    //accept input date as 06%2F07%2F2015+11%3A59+AM from serialized string
    protected  function convertDatepickerFormat($date){
        $parts = explode(' ',$date);

        $date = explode('/',$parts[0]);
        $result = $date[2] . '-' . $date[1] . '-' . $date[0] . ' ';

        $time = explode(':',$parts[1]);
        if($parts[2] === 'PM' && intval($time[0]) != 12){
            $time[0] = strval(intval($time[0]) + 12);
        }else if($parts[2] === 'AM' && intval($time[0]) == 12){
            $time[0] = '00';
        }
        $result = $result . $time[0] . ':' . $time[1] . ':' . '00';

        return $result;
    }
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $course_id
	 * @return Response
	 */
	public function show($course_id)
	{
		$course = Course::findOrFail($course_id);

        dd($course->courseName);

        return view('homework.show', compact('course'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function result(){
        $course=$_GET['course'];
        $sec=$_GET['sec'];
        $homework=DB::select('select * from homework where course_id=? and section=?
                                and semester=? and year=?',array($course,$sec,Session::get('semester'),Session::get('year')));
        $sent=DB::select('select cs.student_id  from course_student cs
                           where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=?',
                            array($course,$sec,Session::get('semester'),Session::get('year')));
        return view('homework.resulthomework',compact('homework','sent'))->with('course',array('course'=>$course,'sec'=>$sec));

    }

    public function uploadFiles() {

        //need $input['submitted_at'] or $submitted_date
        $input = Input::all();
        $destinationPath = 'uploads';
        $binPath = 'uploads/bin';
        $maxSize = '5000'; // 5 MB
        $maxBinSize = 20000000; // 20 MB
        $submitted_date = Carbon::now(new \DateTimeZone('Asia/Bangkok'));

        //Check max size
        $rules = array(
            'file' => 'max:'.$maxSize,
        );
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make($validation->errors()->first() , 400);
        }

        $homework_template = Homework::find($input['homework_id']);
        $fullname_hw_array = $homework_template->createFullFilename($input['student_id']);
        //Check file name
        if(!in_array($input['file']->getClientOriginalName(),$fullname_hw_array)){
            return Response::make("File name is incorrect" , 400);
        }

        $semester_year = Session::get('semester') . '_' . Session::get('year');

        //insert try catch here
        $destinationPath = $destinationPath . '/' . $semester_year . '/' . $homework_template->course_id .
            '/' . $homework_template->section . '/' . $homework_template->no_id_name;
        if(!file_exists($destinationPath)){
            mkdir($destinationPath, 0777, true);
        };

        //Upload file to server
        $date = new Carbon();
        $student_bin = $binPath . '/' . $input['student_id'];
        foreach($fullname_hw_array as $aHW){
            if(file_exists($destinationPath . '/' . $aHW)){
                if(!file_exists($student_bin)){
                    mkdir($student_bin, 0777);
                }
                //Check if this student file size exceed limit
                $all_std_files = File::allFiles($student_bin);
                $sum_size = 0;
                $oldest_date = '99999999_9999';
                foreach($all_std_files as $aFile){
                    $sum_size = $sum_size + $aFile->getSize();
                    $temp = substr($aFile->getFileName(),0,13);
                    if($temp < $oldest_date){
                        $oldest_file = $aFile->getFileName();
                        $oldest_date = $temp;
                    }
                }
                if($sum_size+$input['file']->getSize() > $maxBinSize){
                    File::delete($student_bin . '/' . $oldest_file);
                }
                File::move($destinationPath . '/' . $aHW,$binPath . '/' . $input['student_id'] . '/' . $date->format('Ymd_hi_') . $aHW);
            }
        }

        $upload_success = $input['file']->move($destinationPath, $input['file']->getClientOriginalName()); // uploading file to given path

//        return Response::make("Finished" , 200);

        if ($upload_success) {

            if($submitted_date <= $homework_template->due_date){
                $status = '1';
            }else if($submitted_date <= $homework_template->accept_date){
                $status = '2';
            }else{
                $status = '3';
            }

            $input_homework = ['course_id'=>$input['course_id'],'section'=>$input['section'],
                'homework_id'=>$input['homework_id'], 'student_id'=>$input['student_id'],
                'semester'=>Session::get('semester'), 'year'=>Session::get('year')];
            $accept_homework = ['course_id'=>$input['course_id'],'section'=>$input['section'],
                'homework_id'=>$input['homework_id'], 'homework_name'=>$input['file']->getClientOriginalName(),
                'student_id'=>$input['student_id'], 'status'=>$status,
                'submitted_at'=>$submitted_date,
                'semester'=>Session::get('semester'), 'year'=>Session::get('year')];

            HomeworkStudent::updateOrCreate($input_homework,$accept_homework);

            return Response::make('success', 200);
        } else {
            return Response::make('Internal server error' , 500);
        }
    }

    public function createAssignment($course_id)
    {
        $course = Course::find($course_id);
        $sections = Course_Section::currentSemester()->where('course_id', '=', $course_id)->get();

        return view('homework.assignment.create', compact('course', 'sections'));
    }

    public function homeworkCreate($course_id){
        $section_list = DB::select("SELECT section FROM course_section WHERE course_id = ? and semester=? and year=?",array($course_id,\Session::get('semester'),\Session::get('year')));
        //$filetype_list = DB::select("SELECT id,extension FROM homework_types");
        $filetype_list = HomeworkType::orderBy('id')->get();
        $homeworks = Homework::where("course_id","=",$course_id)
            ->where("semester","=",\Session::get('semester'))
            ->where("year","=",\Session::get('year'))->get();
        //$homeworks = DB::select("SELECT * FROM homework WHERE course_id=? AND semester=? AND year=?",array($course_id,\Session::get('semester'),\Session::get('year')));
        return view('teacherhomework.createhomework3',['course_id'=>$course_id,'section_list'=>$section_list,'filetype_list'=>$filetype_list,'homeworks'=>$homeworks]);
    }

    public function getHomeworkCreateData($course_id){
        //new Nong
        $homework_list = new Collection();
        $sections = array();

        $section_list = DB::select("SELECT section FROM course_section WHERE course_id = ? and semester=? and year=?",array($course_id,\Session::get('semester'),\Session::get('year')));
        $homework_by_course = DB::select("SELECT name,section,type_id,assign_date,due_date,accept_date FROM homework
                WHERE course_id=? AND semester=? AND year=? ORDER BY name,section",array($course_id,Session::get('semester'),Session::get('year')));
        $distinct_homework_by_course = DB::select("SELECT DISTINCT name,type_id FROM homework
                WHERE course_id=? AND semester=? AND year=? ORDER BY name,section",array($course_id,Session::get('semester'),Session::get('year')));
        if(count($distinct_homework_by_course)<=0){
            $homework_status = \Datatables::of($homework_list)->make(true);
            return $homework_status;
        }
        $data  = [];
        foreach($distinct_homework_by_course as $aHomework){
            $extension = DB::select("SELECT extension FROM homework_types WHERE id=?",array($aHomework->type_id));
            $type_with_extension =  $extension[0]->extension;
            $obj = new \stdClass;
            $obj->name = $aHomework->name;
            $obj->type_id = $type_with_extension;
            foreach($homework_by_course as $myHomework) {
                if($myHomework->name === $aHomework->name){
                    foreach($section_list as $aSection){
                        if( isset($obj->{'due_date'.$aSection->section}) && $obj->{'due_date'.$aSection->section}!=='' ){
                            continue;
                        }elseif($myHomework->section===$aSection->section &&  !isset($obj->{'due_date'.$aSection->section})){
                            $obj->{'due_date'.$aSection->section} = $myHomework->due_date;
                            $obj->{'accept_until'.$aSection->section} = $myHomework->accept_date;
                        }elseif($myHomework->section===$aSection->section && (isset($obj->{'due_date'.$aSection->section}) && $obj->{'due_date'.$aSection->section}==='') ){
                            $obj->{'due_date'.$aSection->section} = $myHomework->due_date;
                            $obj->{'accept_until'.$aSection->section} = $myHomework->accept_date;
                        }else{
                            $obj->{'due_date'.$aSection->section} = '';
                            $obj->{'accept_until'.$aSection->section} = '';
                        }
                    }
                }
            }

            $data[] = $obj;
        }
        $homework_list = new Collection($data);

//        foreach($distinct_homework_by_course as $aHomework){
//            $extension = DB::select("SELECT extension FROM homework_types WHERE id=?",array($aHomework->type_id));
//            $type_with_extension = $aHomework->type_id . '(' . $extension[0]->extension .')';
//
//            $homework_list->push([
//                'name' => $aHomework->name,
//                'type_id' => $type_with_extension
//            ]);
//
//        }
//        foreach($homework_list as $aHomework){
//            foreach($section_list as $aSection){
//                $testHW = $aHomework;
//                $testHW['due_date'.$aSection->section] = $aHomework->due_date;
//                $testHW['accept_date'.$aSection->section] = $aHomework->accept_date;
//            }
//        }


//        'due_date'.$aHomework->section => $aHomework->due_date,
//        'accept_until'.$aHomework->section => $aHomework->accept_date

        $homework_status = \Datatables::of($homework_list)->make(true);

        return $homework_status;
    }

    public function homeworkPostCreate(Request $request)
    {
        $input = Input::all();
        parse_str($input['aData'], $new_input);
        $course_no = $input['course_no'];
        $keys = array_keys($new_input);
        $section_arr = array();
        $exp = '/dueDate([0-9]*)/';
        $type_id = $new_input['extension'];

        foreach ($keys as $key){
            if (preg_match($exp, $key,$matches) == 1){
                array_push($section_arr,$matches[1]);
            }
        }

        if(array_key_exists('newextension',$new_input)){
            $no_whitespace_extension = str_replace(' ','',$new_input['extension']);
            try {
                HomeworkType::create(['extension' => $no_whitespace_extension]);
                $type_id = HomeworkType::where('extension', '=', $no_whitespace_extension)->first()->id;
            }catch(QueryException $e){
                $message = "New extension is exist in database";
            }

            $message =  "we have new extension with id: " . $type_id;
        }else{
            $message = "old extension";
        }

        $date = new \DateTime();
        $section_success_arr = array();
        foreach($section_arr as $aSection){
            try {
                Homework::create(['course_id' => $course_no
                    , 'section' => $aSection
                    , 'name' => $new_input['homeworkname']
                    , 'type_id' => $type_id
                    , 'detail' => $new_input['filedetail']
                    , 'assign_date' => $date
                    , 'due_date' => $new_input['dueDate' . $aSection]
                    , 'accept_date' => $new_input['acceptUntil' . $aSection]
                    , 'created_by' => \Auth::user()->id
                    , 'semester' => Session::get('semester')
                    , 'year' => Session::get('year')]);
                $status="success";
            }catch (QueryException $e){
                if($e->getCode() == 23000 && $e->errorInfo[1] == 1062){
                    $status = "duplicate";
                    Log::error("Duplicate in \"homework\" table(course_id,section,name,type_id,semester,year) :" .$e->getMessage());
                }else{
                    $status = "fail";
                    Log::error("Fail to create homework :" .$e->getMessage());
                }
            }
            $section_success_arr = array_add($section_success_arr,$aSection,$status);
        }

        return response()->json(['message'=> $message,'status'=> $section_success_arr]);
    }

}
