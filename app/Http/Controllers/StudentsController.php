<?php namespace App\Http\Controllers;

use App\Course;
use App\Course_Section;
use App\Http\Requests\Formstudents;
use App\Http\Controllers\Controller;

use App\Students;
use App\User;
use function GuzzleHttp\json_encode;
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
//		$students =DB::select('select * from users WHERE  role_id=0001');
        $students = User::student()->currentSemester()->first();
        dd($students);
		//return view('students.index', compact('students'));
        return view('students.index', compact('students'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
	    $readonly = '';
	    $id = null;
	    if ($request->has('course_id')){
	        if (is_null(Course::find($request->input('course_id'))))
	            return abort(404);

            $id = $request->input('course_id');
            $readonly = 'readonly';
        }

        $course = Course::lists('name','id');

        $page_name = 'Add Student';
        $sub_name = 'Manual';

        $sections = Course_Section::where('course_id', $id)
            ->where('semester', Session::get('semester'))
            ->where('year', Session::get('year'))
            ->orderBy('section')
            ->lists('section', 'section');

		return view('students.create',compact('course', 'sub_name', 'page_name', 'id', 'sections','readonly'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$course_id = $request->input('course_id');
        $section = $request->input('section');

        if (empty($section)){
            return redirect()->back()
                ->withErrors(['no_section'=>'No section enter']);
        }
        $findCourseSection = Course_Section::where('course_id', $course_id)
            ->where('section' , $section)
            ->where('semester', Session::get('semester'))
            ->where('year', Session::get('year'))
            ->first();
        if (is_null($findCourseSection)){
            return redirect()->back()
                ->withErrors(['not_found_course_section'=>'Not found course "' . $course_id . '" section "' . $section. '"']);
        }

        $student_id=$request->input('student_id');
        $status=$request->input('status');

        $check=DB::select('select * from course_student where course_id=? and section=? and student_id=?
                            and semester=? and year=?',array($course_id,$section,$student_id,Session::get('semester'),Session::get('year')));
        if(count($check)>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'รหัสนักศึกษา '.$student_id.' ซ้ำ']);
        }

        $user = User::find($student_id);
        if (is_null($user))
            return redirect()->back()->withErrors(['not_found'=>'ไม่พบผู้ใช้งานที่มีรหัส '. $student_id]);

        $insert=DB::insert('insert into course_student (course_id,section,student_id,status,semester,year) VALUES (?,?,?,?,?,?)',array($course_id,$section,$student_id,$status,Session::get('semester'),Session::get('year')));

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

        $result =DB::select('SELECT re.student_id,st.firstname_th,st.lastname_th,st.email 
          FROM users st
          left join course_student re 
          on st.id=re.student_id
          where  re.course_id=? 
          and re.section=?
          and re.semester=? 
          and re.year=?
          order by re.student_id asc',
            array($course,$sec,Session::get('semester'),Session::get('year')));

        $result = json_decode(json_encode($result), true);
        $templateColumns = ['รหัสนักศึกษา', 'ชื่อ', 'นามสกุล', 'อีเมล'];
        array_unshift($result, $templateColumns);
        $fileName = $course.'_'.$sec.'.xlsx';

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);

        if (!\File::exists(storage_path('excel')))
            \File::makeDirectory(storage_path('excel'));

        \File::move(public_path($fileName), storage_path('excel/'.$fileName));

        return response()->download(storage_path('excel/'.$fileName));
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

    public function importByCourseSection($course_id, $section)
    {
        $found = Course_Section::where('course_id', $course_id)
            ->where('section', $section)
            ->where('semester', Session::get('semester'))
            ->where('year', Session::get('year'))
            ->first();

        if (is_null($found))
            return abort(404);

        if ($this->regImportOneSection($course_id, $section))
            return redirect("index/preview?course={$course_id}&sec={$section}");

        return abort(402);
    }

    public function autoImportByOne(Request $request)
    {
        $courseSections = Course_Section::where('semester', Session::get('semester'))
            ->where('year', Session::get('year'))
            ->groupBy('course_id','section')
            ->orderBy('course_id', 'section')
            ->select(DB::raw('course_id,section'))
            ->get();

        return view('students.auto_import_by_one', compact('courseSections'));
    }

    public function regImportOneSection($course_id , $section)
    {
        $semester=Session::get('semester');
        $year=substr(Session::get('year'),-2);
        $excelType = 'Excel2007';

        if($section=='000'){
            $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course_id.'&SECLEC='.$section.'&SECLAB=001&border=1&mime=xlsx&ctype=&';
        }else {
            $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course_id.'&SECLEC='.$section.'&SECLAB=000&border=1&mime=xlsx&ctype=&';
        }

        $filename = "import{$course_id}_{$section}.xlsx";
        $fileupload = tempnam(sys_get_temp_dir(), $filename);

        if(copy($fileupload_name,$fileupload)){
            $reader = \PHPExcel_IOFactory::createReader($excelType);
            if (!$reader->canRead($fileupload)){
                return null;
            }

            $objPHPExcel =\PHPExcel_IOFactory::load($fileupload);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'

                for ($row =8; $row <= $highestRow; ++ $row) {
                    $cell = $worksheet->getCellByColumnAndRow(1,$row);
                    $no = $cell->getValue();
                    $cell = $worksheet->getCellByColumnAndRow(2,$row);
                    $code = (string)$cell->getValue();
                    $cell = $worksheet->getCellByColumnAndRow(3,$row);
                    $fname = $cell->getValue();
                    $cell = $worksheet->getCellByColumnAndRow(4,$row);
                    $lname = $cell->getValue();
                    $cell=$worksheet->getCellByColumnAndRow(5,$row);
                    $status=$cell->getValue();

                    if ($no>0 && $no<=200) {
                        $reg=DB::select(' select * from course_student where course_id=? and section=? and student_id=?
                                                  and semester=? and year=?',array($course_id,$section,$code,Session::get('semester'),Session::get('year')));
                        $user=DB::select('select * from users where id=? ',array($code));
                        $cuser=count($user);
                        $rowregist=count($reg);
                        if ($rowregist==0 && $cuser==0 ) {
                            //  $command =DB::insert('insert into students (id,studentName,status) values (?,?,?)',array($code,$fullnames,$status)) ;
                            DB::insert('insert into users (id,firstname_th,lastname_th,role_id) values (?,?,?,?)',array($code,$fname,$lname,'0001')) ;
                            DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course_id,$section,$status,Session::get('semester'),Session::get('year')));
                        }
                        if ($rowregist==0 && $cuser>0 ) {
                            DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course_id,$section,$status,Session::get('semester'),Session::get('year')));
                        }
                        if($rowregist>0){
                            if($reg[0]->status!=$status){
                                DB::update('update course_student set status=? where student_id=?
                                                          and semester=? and year=?',array($status,$code,Session::get('semester'),Session::get('year')));
                            }
                        }

                    }
                }
            }
        }else{
            return null;
        }

        return true;
    }

    public function autoimport(Request $request)
    {
        libxml_use_internal_errors(false);
        set_time_limit(0);

        $semester=Session::get('semester');
        $fullYear = Session::get('year');
        $year=substr(Session::get('year'),-2);

        if ($request->has('semester') && $request->has('year')){
            $semester = $request->get('semester');
            $fullYear = $request->get('year');
            $year = substr($fullYear, -2);
        }

        $sql=DB::select('select course_id,section  
from course_section 
where semester=? 
and year=? 
GROUP BY course_id,section', array($semester, $fullYear));

        $excelType = 'Excel2007';
        $count=count($sql);
        $j=0;
        $k=0;

        $importStatus = array();

        for($i=0;$i<$count;$i++){
            $course = $sql[$i]->course_id;
            $sec = $sql[$i]->section;

            $newStatus = new \stdClass();
            $newStatus->{'course_id'} = $course;
            $newStatus->{'section'} = $sec;

            if($sec=='000'){
                $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=001&border=1&mime=xlsx&ctype=&';
            }else {
                $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=000&border=1&mime=xlsx&ctype=&';
            }
//            echo $course . " " . $sec . "</br>";
//            echo $fileupload_name . "</br>";
            $filename = 'file'.$i.'.xlsx';
            $fileupload = tempnam(sys_get_temp_dir(), $filename);

            if(copy($fileupload_name,$fileupload)){

                $reader = \PHPExcel_IOFactory::createReader($excelType);
                if (!$reader->canRead($fileupload)){
//                    echo 'cannot download file from ' . $course . ' - ' . $sec . "</br>";
                    $newStatus->{'status'} = User::IMPORT_NOT_FOUND;
                    $newStatus->{'amount'} = 0;
                    $importStatus[] = $newStatus;
                    continue;
                }

                $sco[$j]=$course;
                $sse[$j]=$sec;
                $l=0;
                $objPHPExcel =\PHPExcel_IOFactory::load($fileupload);

                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $worksheetTitle     = $worksheet->getTitle();
                    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                    $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                    $nrColumns = ord($highestColumn) - 64;

                    for ($row =8; $row <= $highestRow; ++ $row) {
                        $cell = $worksheet->getCellByColumnAndRow(1,$row);
                        $no = $cell->getValue();
                        $cell = $worksheet->getCellByColumnAndRow(2,$row);
                        $code = (string)$cell->getValue();
                        $cell = $worksheet->getCellByColumnAndRow(3,$row);
                        $fname = $cell->getValue();
                        $cell = $worksheet->getCellByColumnAndRow(4,$row);
                        $lname = $cell->getValue();
                        $cell=$worksheet->getCellByColumnAndRow(5,$row);
                        $status=$cell->getValue();

                        if ($no>0 && $no<=200) {
                            $reg=DB::select(' select * from course_student where course_id=? and section=? and student_id=?
                                                  and semester=? and year=?',array($course,$sec,$code,Session::get('semester'),Session::get('year')));
                            $user=DB::select('select * from users where id=? ',array($code));
                            $cuser=count($user);
                            $rowregist=count($reg);
                            if ($rowregist==0 && $cuser==0 ) {
                                //  $command =DB::insert('insert into students (id,studentName,status) values (?,?,?)',array($code,$fullnames,$status)) ;
                                $command =DB::insert('insert into users (id,firstname_th,lastname_th,role_id) values (?,?,?,?)',array($code,$fname,$lname,'0001')) ;
                                $regis =DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course,$sec,$status,Session::get('semester'),Session::get('year')));
                                $l++;
                            }
                            if ($rowregist==0 && $cuser>0 ) {
                                $regis =DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course,$sec,$status,Session::get('semester'),Session::get('year')));
                                $l++;
                            }
                            if($rowregist>0){
                                if($reg[0]->status!=$status){
                                    $update=DB::update('update course_student set status=? where student_id=?
                                                          and semester=? and year=?',array($status,$code,Session::get('semester'),Session::get('year')));
                                }
                            }

                        }
                    }
                    $newStatus->{'amount'} = $no;
                }
                $stu[$j]=$l;
                $j++;

                $newStatus->{'status'} = User::IMPORT_SUCCESS;
                $importStatus[] = $newStatus;
            }else{
                $fco[$k]=$course;
                $fse[$k]=$sec;
                $k++;

            }
        }

//        dd(json_encode($importStatus));
        $page_name = 'Student';
        $sub_name = 'Import Result ' . $semester . '-' . $year;
        return view('students.autoinsert', compact('importStatus','page_name','sub_name','semester','year'));
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

    public function displayCourseHomeworkPage($course_id, $section)
    {
        return view('student.homework.index');
    }
}