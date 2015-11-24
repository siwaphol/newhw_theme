<?php //namespace App\Http\Controllers;
//
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
//
//use App\Homework_assignments;
//use Illuminate\Http\Request;
//use Carbon\Carbon;
//use DB;
//
//class Homework_assignmentController extends Controller {
//
//	/**
//	 * Display a listing of the resource.
//	 *
//	 * @return Response
//	 */
//    public function index()
//    {
//
//        return view('homework_assignment.index');
//    }
//	public function showlist()
//	{   $course=$_POST['ddlCourse'];
//        $homework_assignments =DB::select('select id,homeworkFileName,homeworkFileType,homeworkDetail,subFolder,dueDate,assignDate FROM homework_assignment WHERE courseId=? ORDER BY id asc',array($course));
//
//		//$homework_assignments = Homework_assignments::latest()->get();
//		return view('homework_assignment.showlist', compact('homework_assignments','course'));
//	}
//
//	/**
//	 * Show the form for creating a new resource.
//	 *
//	 * @return Response
//	 */
//	public function create($id)
//	{
//		return view('homework_assignment.create')->with('course',array('co'=>$id));
//	}
//
//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @return Response
//	 */
//	public function store(Request $request)
//	{
//		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
//		Homework_assignments::create($request->all());
//		return redirect('homework_assignment');
//	}
//
//	/**
//	 * Display the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function show($id)
//	{
//		$homework_assignment = Homework_assignments::findOrFail($id);
//		return view('homework_assignment.show', compact('homework_assignment'));
//	}
//
//	/**
//	 * Show the form for editing the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function edit($id)
//	{
//		$homework_assignment = Homework_assignments::findOrFail($id);
//		return view('homework_assignment.edit', compact('homework_assignment'));
//	}
//
//	/**
//	 * Update the specified resource in storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function update($id, Request $request)
//	{
//		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
//		$homework_assignment = Homework_assignments::findOrFail($id);
//		$homework_assignment->update($request->all());
//		return redirect('homework_assignment');
//	}
//
//	/**
//	 * Remove the specified resource from storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function destroy($id)
//	{
//		Homework_assignments::destroy($id);
//		return redirect('homework_assignment');
//	}
//
//}