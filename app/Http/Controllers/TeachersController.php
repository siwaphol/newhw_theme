<?php namespace App\Http\Controllers;

use App\Http\Requests\Formteachers;
use App\Http\Controllers\Controller;

use App\Teachers;
//use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Response;
use View;
use DB;


class TeachersController extends Controller {

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
		$teachers = DB::select('select * from users where role_id=0100');
		return view('teachers.index', compact('teachers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('teachers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Formteachers $request)
	{
        $findid=DB::select('select max(id) as maxid from users where role_id=1000 or role_id=0100');

        $id=intval($findid[0]->maxid);
        $id+=1;
        $id=str_pad($id, 9, "0", STR_PAD_LEFT);
        $username=$request->get('email');
        $firstname_th=$request->get('firstname_th');
        $firstname_en=$request->get('firstname_en');
        $lastname_th=$request->get('lastname_th');
        $lastname_en=$request->get('lastname_en');
        $email=$request->get('email').'@cmu.ac.th';

        $teacher=DB::insert('insert into users (id,username,role_id,firstname_th,firstname_en,lastname_th,lastname_en,email)values(?,?,?,?,?,?,?,?)',array($id,$username,'0100',$firstname_th,$firstname_en,$lastname_th,$lastname_en,$email));
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		//Teachers::create($request->all());
		return redirect('teachers');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $teacher =DB::select('select * from users where id=?',array($id));
		return view('teachers.show', compact('teacher'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $teacher =DB::select('select * from users where id=?',array($id));
		return view('teachers.edit', compact('teacher'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update( Formteachers $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
        $id=$request->get('id');
        $username=$request->get('username');
        $firstname_th=$request->get('firstname_th');
        $firstname_en=$request->get('firstname_en');
        $lastname_th=$request->get('lastname_th');
        $lastname_en=$request->get('lastname_en');
        $email=$request->get('email');
        $update=DB::update('update users set username=?,firstname_th=?,firstname_en=?,lastname_th=?,lastname_en=?,email=? where id=?',array($username,$firstname_th,$firstname_en,$lastname_th,$lastname_en,$email,$id));
		return redirect('teachers');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$Teachers=DB::delete('delete from users where id=?',array($id));
		return redirect('teachers');
	}

}