<?php //namespace App\Http\Controllers;
//
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
//
//use App\Crud-teachers;
//use Illuminate\Http\Request;
//use Carbon\Carbon;
//
//class Crud-teachersController extends Controller {
//
//	/**
//	 * Display a listing of the resource.
//	 *
//	 * @return Response
//	 */
//	public function index()
//	{
//		$crud-teachers = Crud-teachers::latest()->get();
//		return view('crud-teachers.index', compact('crud-teachers'));
//	}
//
//	/**
//	 * Show the form for creating a new resource.
//	 *
//	 * @return Response
//	 */
//	public function create()
//	{
//		return view('crud-teachers.create');
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
//		Crud-teachers::create($request->all());
//		return redirect('crud-teachers');
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
//		$crud-teacher = Crud-teachers::findOrFail($id);
//		return view('crud-teachers.show', compact('crud-teacher'));
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
//		$crud-teacher = Crud-teachers::findOrFail($id);
//		return view('crud-teachers.edit', compact('crud-teacher'));
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
//		$crud-teacher = Crud-teachers::findOrFail($id);
//		$crud-teacher->update($request->all());
//		return redirect('crud-teachers');
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
//		Crud-teachers::destroy($id);
//		return redirect('crud-teachers');
//	}
//
//}