<?php namespace App\Http\Controllers;

use App\Http\Requests\Formtas;
use App\Http\Controllers\Controller;

use App\Tas;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class TasController extends Controller {

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
        $tas =DB::select('select ta.id as id ,u.id as student_id,ta.id as id,firstname_th,lastname_th from users u
                          left join course_ta ta on u.id=ta.student_id
                          where (role_id=0011 or role_id=0010)
                          and ta.semester=? and ta.year=?',array(Session::get('semester'),Session::get('year')));
		return view('tas.index', compact('tas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Formtas $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		Tas::create($request->all());
		return redirect('ta');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $tas =DB::select('select  u.id as student_id,ta.id as id,firstname_th,lastname_th from users u
                          left join course_ta ta on u.id=ta.student_id
                          where (role_id=0011 or role_id=0010) and ta.id=?
                          and ta.semester=? and ta.year=?',array($id,Session::get('semester'),Session::get('year')));

		return view('tas.show', compact('tas'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ta = Tas::findOrFail($id);
		return view('tas.edit', compact('ta'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Formtas $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		$ta = Tas::findOrFail($id);
		$ta->update($request->all());
		return redirect('ta');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tas::destroy($id);
		return redirect('ta');
	}

}