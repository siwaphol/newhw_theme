<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 18/6/2558
 * Time: 20:31
 */
 namespace App\Http\Controllers;

use App\Course;

//use Request;
use App\Http\Requests\CourseRequest;
 use App\Http\Requests\Request;
 use App\User;
 use yajra\Datatables\Datatables;

 class CourseController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

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

        return view('creatcourse');
    }
    public function addcourse(CourseRequest $request)
    {
        $input = $request->all();

        if(count(Course::find($input['course_id'])) > 0){
            return redirect()
                ->back()
                ->withErrors([
                'duplicate' => 'รหัสวิชาซ้ำ',
            ]);
        }
        $Course=Course::create(['id' => $input['course_id'], 'name' => $input['course_name']]);

        return redirect('course');
    }
    public function show($course_id){

        return view('homework.studenthomework',['course_id'=>$course_id]);
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
