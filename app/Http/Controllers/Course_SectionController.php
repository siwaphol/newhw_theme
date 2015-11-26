<?php namespace App\Http\Controllers;

use App\Http\Requests\course_section;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Course_Section as CS;
use Illuminate\Support\Collection;
use Log;
use Session;
use Illuminate\Http\RedirectResponse;
use App\Course;
class Course_SectionController extends Controller
{

    public function index()
    {
        $result = DB::select('select cs.course_id as courseid
                              ,cs.section as sectionid
                              ,t.firstname_th as firstname
                              ,t.lastname_th as lastname
                              ,co.name as coursename
                              ,cs.id as id
                              from course_section cs
                              left join users t on cs.teacher_id=t.id
                              left join courses co on cs.course_id=co.id
                              WHERE  t.role_id=0100
                              and cs.semester=? and cs.year=?
                              order by cs.course_id,cs.section
                              ',array(Session::get('semester'),Session::get('year')));

        return view('course_section.index', compact('result'));
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $courseid = $_GET['course'];
        $sectionid = $_GET['sec'];
        $result = DB::select('select cs.id as id
                              ,cs.course_id as courseid
                              ,cs.section as sectionid
                              ,t.firstname_th as firstname
                              ,t.lastname_th as lastname
                              ,co.name as coursename
                              ,cs.teacher_id as teacherid
                              from course_section cs
                              left join users t on cs.teacher_id=t.id
                              left join courses co on cs.course_id=co.id
                              where cs.course_id=? and cs.section=? and cs.semester=? and cs.year=?
                              ', array($courseid, $sectionid,Session::get('semester'),Session::get('year')));

        return view('course_section.edit', compact('result'));
    }

    public function update()
    {
        $id=$_POST['id'];
        //dd($_POST['courseid']);
        $courseid =$_POST['courseid'];
        $sectionid =$_POST['sectionid'];
        $teacherid =$_POST['teacherid'];
        $sql=DB::select('select * from course_section where id=?',array($id));
        $check=DB::select('select tea.firstname_th as firstname,tea.lastname_th as lastname
                          ,cs.course_id as course_id
                          ,cs.section as section
                          from course_section cs
                          left JOIN users tea on cs.teacher_id=tea.id
                          where cs.course_id=? and cs.section=? and cs.teacher_id=?
                          and cs.semester=? and cs.year=?',
                            array($courseid,$sectionid,$teacherid,Session::get('semester'),Session::get('year')));
        if(count($check)>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'กระบวนวิชา '.$check[0]->course_id.' ตอน '.$check[0]->section.' อาจารย์'.$check[0]->firstname.' '.$check[0]->lastname.' ซ้ำ']);
        }
        $cs = CS::find($id);
//        $cs->course_id=$courseid;
      $cs->section=$sectionid;
        $cs->teacher_id=$teacherid;
        $cs->save();
        // $course = DB::update('update course_section set course_id=?,section=?,teacher_id=? where course_id=? and section=?', array($courseid, $sectionid, $teacherid, $courseid, $sectionid));
        return redirect('home');
    }

    public  function create(){

        return view('course_section.create');
    }

    /**
     * @param course_section $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(course_section $request)
    {
         $courseid = $request->get('courseid');
        $sectionid = $request->get('sectionid');
        $teacherid = $request->get('teacherid');
        $check=DB::select('select tea.firstname_th as firstname,tea.lastname_th as lastname from course_section cs
                          left JOIN users tea on cs.teacher_id=tea.id
                          where cs.course_id=? and cs.section=? and cs.teacher_id=?
                          and cs.semester=? and cs.year=?',array($courseid,$sectionid,$teacherid,Session::get('semester'),Session::get('year')));

        if(count($check)>0){
            return redirect()->back()
                ->withErrors(['duplicate' => 'กระบวนวิชา '.$courseid.' ตอน '.$sectionid.' อาจารย ์'.$check[0]->firstname.' '.$check[0]->lastname.' ซ้ำ']);
        }

        $cs=new CS();
        $cs->course_id=$courseid;
        $cs->section=$sectionid;
        $cs->teacher_id=$teacherid;
        $cs->semester=Session::get('semester');
        $cs->year=Session::get('year');
        $cs->save();

        //$Course = DB::insert('insert into course_section(course_id,section,teacher_id)VALUES (?,?,?)', array($courseid, $sectionid, $teacherid));

        //return redirect('course_section');
        return new RedirectResponse(url('home'));
    }
    public function delete(){
            $course=$_GET['course'];
            $sec=$_GET['sec'];
            $id=$_GET['id'];
            $result=DB::delete('delete from course_section where course_id=? and section=?
                                and semester=? and year=? and id=?',array($course,$sec,Session::get('semester'),Session::get('year'),$id));
        //return redirect('course_section');
        return redirect('home');
    }
    public function check(){
        $course = $_POST['course'];
        $sec = $_POST['sec'];

        $result=DB::select('select * from course_section where course_id=? and section=? ',array($course,$sec));
       dd($result);
        $count=count($result);
        if($count>0){
            return 0;

        }else{
            return 1;
        }


    }
    public function selectcreate(){

        return view('course_section.selectcreate');
    }
    public function createteacher(){
        $courseid=$_POST['courseid'];
        $section=$_POST['sectionid'];
        return view('course_section.createteacher')->with('course',array('co'=>$courseid,'sec'=>$section));
    }
    public function saveteacher(){

        $courseid=$_POST['courseid'];
        $sectionid=$_POST['sectionid'];
        $teacherid=$_POST['teacherid'];
        $count=count($sectionid);


        for($i=0;$i<$count;$i++) {

            $check = DB::select('select tea.firstname_th as firstname,tea.lastname_th as lastname from course_section cs
                          left JOIN users tea on cs.teacher_id=tea.id
                          where cs.course_id=? and cs.section=? and cs.teacher_id=?
                          and cs.semester=? and cs.year=?', array($courseid, $sectionid[$i], $teacherid[$i], Session::get('semester'), Session::get('year')));

            if (count($check) == 0) {
            $cs = new CS();
            $cs->course_id = $courseid;
            $cs->section = $sectionid[$i];
            $cs->teacher_id = $teacherid[$i];
            $cs->semester = Session::get('semester');
            $cs->year = Session::get('year');
            $cs->save();
            }

        }

        return redirect('course_section');
    }

    public function file_get_contents_utf8($fn) {
        $opts = array(
            'http' => array(
                'method'=>"GET",
                'header'=>"Content-Type: text/html; charset=tis-620"
            )
        );

        $context = stream_context_create($opts);
        $result = @file_get_contents($fn,false,$context);
        return $result;
    }
    /**
     * @input text from web page (not html value)
     * @return collection of all course
     */
//    protected function turnHTMLtoCollection($courseArray){
//        //Assumming first line is "204100 - IT AND MODERN LIFE (11 Sections)"
//        $regex_for_course_no = '/204[0-9]{3}/';
//        $regex_for_course_name = '/-(.*?)\(/';
//        $regex_for_sections = '/\((.*?)\)/';
//        $result_collection = array();
//
//        foreach($courseArray as $aCourse){
//            preg_match($regex_for_course_no, $aCourse, $match);
//            $course_no = $match[0];
//            preg_match($regex_for_course_name, $aCourse, $match);
//            $course_name = trim($match[1]);
//            preg_match($regex_for_sections, $aCourse, $match);
//            $temp = explode(' ',$match[1]);
//            $section_count = $temp[0];
//
//            preg_match_all('/'.$course_name.'\b.*$/m',$aCourse,$all_lines_contain_course_name);
//
//            //Assume each line will be like "$course_name 001000"
//            array_shift($all_lines_contain_course_name[0]);
//            array_push($result_collection,$all_lines_contain_course_name[0]);
//        }
//
//        dd($result_collection);
//        return false;
//    }

    protected function getTeacherName($inputString)
    {

        $exclude_teacher_name_en = 'staff';

        $inputString = str_replace('<br>','&',$inputString);
        $inputString = str_replace('</br>','&',$inputString);
        $inputString = str_replace('<b>co-instructor</b>','&',$inputString);

        $found_name_th = false;
        $f_index = strpos($inputString,'<td in title=');
        $pos = $f_index;
        $stringArray = str_split($inputString);
        $a_tag = '';
        $teacher_name_th = '';
        $teacher_name_en = '';
        while($a_tag !== '</td>' && $pos < strlen($inputString)){
            if($stringArray[$pos]=== '&'){
                $a_tag .= $stringArray[$pos];
                while($stringArray[$pos]=== '&' && $pos < strlen($inputString) ){
                    $pos = $pos + 1;
                }
            }
            if(substr($a_tag,-1) === '>'){
                $a_tag='';
            }
            if($stringArray[$pos]=== '<'){
                $teacher_name_en = $a_tag;
                $a_tag = '';
            }
            $a_tag .= $stringArray[$pos];
            if($stringArray[$pos]==='"' && !$found_name_th){
                $pos = $pos + 1;
                while($stringArray[$pos]!=='"' && $pos < strlen($inputString)){
                    $teacher_name_th .= $stringArray[$pos];
                    $a_tag .= $stringArray[$pos];
                    $pos = $pos + 1;
                }
                $a_tag .= $stringArray[$pos]; //closing "
                $found_name_th = true;
            }
            $pos = $pos+1;
        }
        $teacher_name_th = trim($teacher_name_th);
        $teacher_name_en = trim($teacher_name_en);
        if(substr($teacher_name_th,-1)==='&'){
            $teacher_name_th = substr($teacher_name_th,0,strlen($teacher_name_th)-1);
        }
        if(substr($teacher_name_en,-1)==='&'){
            $teacher_name_en = substr($teacher_name_en,0,strlen($teacher_name_en)-1);
        }
        $teacher_name_th = str_replace('#13;','',$teacher_name_th);
        $teacher_name_en = str_replace('#13;','',$teacher_name_en);
        //turn multiple spaces to single whitespace
        $teacher_name_th = preg_replace('!\s+!', ' ', $teacher_name_th);
        $teacher_name_en = preg_replace('!\s+!', ' ', $teacher_name_en);

        $teacher_for_section_array = array();
        $one_teacher_array = array('firstname_en'=>'','lastname_en'=>'','firstname_th'=>'','lastname_th'=>'');
        //turn multiple teacher name to array
        $name_th_array = explode("&",$teacher_name_th);
        $name_en_array = explode("&",$teacher_name_en);
        //trim
        $name_th_array = array_map('trim',$name_th_array);
        $name_en_array = array_map('trim',$name_en_array);

        for($i=0; $i<count($name_en_array); $i++){
            $uppercase_name = ucwords($name_en_array[$i]);

            $firstname_en = "";
            $lastname_en = "";
            $firstname_th = "";
            $lastname_th = "";
            if(strtoupper($uppercase_name)!==strtoupper($exclude_teacher_name_en)){
                $temp_en = explode(' ',$uppercase_name);
                if(count($temp_en)==2){
                    $firstname_en = trim($temp_en[0]);
                    $lastname_en = trim($temp_en[1]);
                }else if(count($temp_en)==1){
                    $firstname_en = trim($temp_en[0]);
                    $lastname_en = "";
                }
                $temp_th = explode(' ',$name_th_array[$i]);
                if(count($temp_th)==2){
                    $firstname_th = trim($temp_th[0]);
                    $lastname_th = trim($temp_th[1]);
                }else if(count($temp_th)==1){
                    $firstname_th = trim($temp_th[0]);
                    $lastname_th = "";
                }
                $one_teacher_array['firstname_en'] = $firstname_en;
                $one_teacher_array['lastname_en']  = $lastname_en;
                $one_teacher_array['firstname_th'] = $firstname_th;
                $one_teacher_array['lastname_th']  = $lastname_th;

                array_push($teacher_for_section_array,$one_teacher_array);
            }
        }

        return $teacher_for_section_array;
    }
    public function auto(Request $request){

//        return view('admin.course_section_import');

        $postdata = http_build_query(
            array(
                'op' => 'precourse',
                'precourse' => '204'
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $semester=Session::get('semester');
        $year=substr(Session::get('year'),-2);
        if(env('APP_DEBUG')){
            $result = \File::get('C:\xampp\htdocs\newHW\temp\regist157.txt');
        }else{
            $context  = stream_context_create($opts);
            $result = file_get_contents('https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/search.php?act=search', false, $context);
        }

        $e_result = explode('<span coursetitle>',$result);
        array_shift($e_result);
        $all_courses_array = array();

        foreach($e_result as $aCourse){
            //for closed course will be <tr coursedata close>
            $e2_result= explode('<tr coursedata',$aCourse);

            preg_match('/([0-9]{6}) - (.*?) \(([0-9]{1,2}) Section[s]?\)/',strip_tags($e2_result[0]),$matches);
            $a_course_array = array();
            if(count($matches)==4){
                $course_no = $matches[1];
                $course_name = $matches[2];
                $course_section_count = $matches[3];
                $a_course_array = array('id'=>$course_no,'name'=>$course_name,'sections'=>array());
                try {
                    Course::findOrFail($course_no);
                }catch (ModelNotFoundException $e){
                    Log::info($e->getMessage() . '\nNew Course was created: ' .$course_no.' '.$course_name);
                    $new_course = new Course();
                    $new_course->id = $course_no;
                    $new_course->name = ucwords($course_name);
                    $new_course->save();
                }
            }else{
                Log::error('Cannot find course details in this block of text: ' . strip_tags($e2_result[0]));
                continue;
            }
            array_shift($e2_result);

            foreach ($e2_result as $aSection) {
                $a_section_array = array();
                preg_match('/SECLEC=([0-9]{3})&SECLAB=([0-9]{3})/', $aSection, $section_matches);
                if(count($section_matches)==3) {
                    if ($section_matches[1] === '000') {
                        $course_sec = $section_matches[2];
                    } else {
                        $course_sec = $section_matches[1];
                    }
                    $a_section_array = array_add($a_section_array,'no',$course_sec);
                }else{
                    Log::error('Cannot find course section in this block of text: ' . $aSection);
                    continue;
                }
                $t_array_for_section = $this->getTeacherName($aSection);
                $a_section_array = array_add($a_section_array,'teacher',$t_array_for_section);

                //push one section to course
                array_push($a_course_array['sections'],$a_section_array);
            }
            //push one course to all courses array
            array_push($all_courses_array,$a_course_array);

        } //end foreach foreach($e_result as $aCourse)

        //test here is where we put all section details to Course_Section model
        //if search (use English first name and last name) and did not found
        $semester = Session::get("semester");
        $year = Session::get("year");
        //success 0 = success , 1= duplicate, 2=fail
        $overview = array('course_id'=>array(),'course_name'=>array(),'section'=>array(),'teacher_name'=>array(),'success'=>array(),'detail'=>array());
        $count_summary = array(0,0,0);

        foreach($all_courses_array as $aCourse){
            foreach($aCourse['sections'] as $aSection){
                foreach($aSection['teacher'] as $aTeacher){
                    $old_course_section = null;
                    $teacher = null;
                    //find if there is this teacher in database
                    try {
                        $teacher = User::where('firstname_en',trim($aTeacher['firstname_en']))
                            ->where('lastname_en',trim($aTeacher['lastname_en']))->firstOrFail();
                        $teacher_id = $teacher->id;
                    }catch (ModelNotFoundException $e){
                        $last_emp_id = User::lastEmployee()->id;
                        $new_employee = new User();
                        $new_id = intval($last_emp_id) + 1;
                        $new_employee->id = str_pad((string)$new_id,9,"0",STR_PAD_LEFT);
                        $new_employee->role_id = '0100';
                        $new_employee->firstname_th = $aTeacher['firstname_th'];
                        $new_employee->lastname_th = $aTeacher['lastname_th'];
                        $new_employee->firstname_en = $aTeacher['firstname_en'];
                        $new_employee->lastname_en = $aTeacher['lastname_en'];
                        $new_employee->faculty_id = '05';
                        $new_employee->semester = $semester;
                        $new_employee->year = $year;
                        $new_employee->save();
                        $teacher_id = $new_employee->id;
                    }
                    //find if there is course section with the exact same courseid,section,teacherid,semester,year
                    try{
                        $course_section_model = \App\Course_Section::where('course_id', $aCourse['id'])
                            ->where('section', $aSection['no'])
                            ->where('teacher_id', $teacher_id)
                            ->where('semester', $semester)
                            ->where('year', $year)->firstOrFail();

                        array_push($overview['course_id'],$aCourse['id']);
                        array_push($overview['course_name'],$aCourse['name']);
                        array_push($overview['section'],$aSection['no']);
                        array_push($overview['teacher_name'],$aTeacher['firstname_en'] .' ' . $aTeacher['lastname_en'] . ' ' . $aTeacher['firstname_th'] . ' ' . $aTeacher['lastname_th']);
                        array_push($overview['success'],1);
                        array_push($overview['detail'],'Duplicate course section is already exist.');
                        $count_summary[1] = $count_summary[1] + 1;
                    }catch (ModelNotFoundException $e){
                        $course_section_model = new \App\Course_Section();
                        $course_section_model->course_id = $aCourse['id'];
                        $course_section_model->section = $aSection['no'];
                        $course_section_model->teacher_id = $teacher_id;
                        $course_section_model->semester = $semester;
                        $course_section_model->year = $year;
                        $save_result = $course_section_model->save();

                        array_push($overview['course_id'],$aCourse['id']);
                        array_push($overview['course_name'],$aCourse['name']);
                        array_push($overview['section'],$aSection['no']);
                        array_push($overview['teacher_name'],$aTeacher['firstname_en'] .' ' . $aTeacher['lastname_en'] . ' ' . $aTeacher['firstname_th'] . ' ' . $aTeacher['lastname_th']);

                        if($save_result){
                            array_push($overview['success'],0);
                            array_push($overview['detail'],'');
                            $count_summary[0] = $count_summary[0] + 1;
                        }else{
                            array_push($overview['success'],2);
                            array_push($overview['detail'],'Fail to create new course section data.');
                            $count_summary[2] = $count_summary[2] + 1;
                        }
                    }
                }
                if(count($aSection['teacher'])==0){
                    //In case no teacher name found
                    array_push($overview['course_id'],$aCourse['id']);
                    array_push($overview['course_name'],$aCourse['name']);
                    array_push($overview['section'],$aSection['no']);
                    array_push($overview['teacher_name'],'');
                    array_push($overview['success'],2);
                    array_push($overview['detail'],'Cannot find teacher name or only "Staff" found.');
                    $count_summary[2] = $count_summary[2] + 1;
                }
            }
        }
        //endtest
        $count_overview = $count_summary[0]+$count_summary[1]+$count_summary[2];

        if($request->ajax()){
            dd($overview);
        }
        return view('admin.course_section_import',compact('overview','count_summary','count_overview'));
    }
}
