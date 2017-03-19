<?php

 namespace App\Http\Controllers;

use App\Course;

use App\Course_Section;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

 class CourseController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */


    public function index(){

        $model=Course::all();
        $page_name = 'Course';
        $sub_name = 'Overview';

        return view('course',compact('model','page_name','sub_name'));
    }
    public function create(){

        return view('course/create');
    }

     public function store(Request $request)
     {
         $input = $request->all();

         $oldCourse = Course::find($input['course_id']);
         if(!is_null($oldCourse)){
             flash('Duplicate course no','danger');
             return redirect()
                 ->back()
                 ->withErrors([
                     'duplicate' => 'รหัสวิชาซ้ำ',
                 ]);
         }

         Course::create(['id' => $input['course_id'], 'name' => $input['course_name']]);
         flash('Course created','success');

         return redirect('course')->with('message','Course created');
    }
//    public function addcourse(CourseRequest $request)
//    {
//        $input = $request->all();
//
//        if(count(Course::find($input['course_id'])) > 0){
//            return redirect()
//                ->back()
//                ->withErrors([
//                'duplicate' => 'รหัสวิชาซ้ำ',
//            ]);
//        }
//        $Course=Course::create(['id' => $input['course_id'], 'name' => $input['course_name']]);
//
//        return redirect('course');
//    }
    public function show($id){
        $course = Course::find($id);

        $sections = Course_Section::leftJoin('users', 'course_section.teacher_id', '=','users.id')
            ->where('course_id', $id)
            ->where('course_section.semester', \Session::get('semester'))
            ->where('course_section.year', \Session::get('year'))
            ->select(\DB::raw('users.firstname_en, users.lastname_en,users.firstname_th,users.lastname_th
            ,course_section.course_id,course_section.section, course_section.id'))
            ->get();

        $sections = $sections->groupBy('section');

        return view('course.show',compact('course','sections'));
    }

     public function getStudentHomeworkData($course_id){
         $homework_status = \Auth::user()->getHomeworkWithStatus('204111','001');

         return $homework_status;
     }

    public function edit($id){

        $course=Course::find($id);

        return view('course.edit',compact('course'));
    }

    public function saveedit(Request $request){

    $input = $request->input('id');
    $Course=Course::findOrfail($input);

    $input = $request->all();

    $Course->fill($input)->save();

    return redirect('course');

}
    public function delete($id){
        $Course=Course::findOrfail($id);
        $Course->delete();
        return redirect('course');
    }

}
