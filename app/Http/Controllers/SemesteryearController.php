<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Semesteryears;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SemesteryearController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$semesteryears =DB::select('select * from semester_year ORDER BY  year desc,semester desc ');
		return view('semesteryear.index', compact('semesteryears'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('semesteryear.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $check = DB::select('select * from semester_year where semester=? and year=?', array($request->get('semester'),$request->get('year')));

        if (count($check) > 0) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'ภาคเรียน ' .$request->get('semester') . ' ปีการศึกษา' . $request->get('year').' ซ้ำ']);
        }

	//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
        $semester=new Semesteryears();
        $semester->semester=$request->get('semester');
        $semester->year=$request->get('year');
        $semester->use=1;
        $semester->save();
        $lastid = $semester->id;
        $sql=DB::select('select * from semester_year');
        foreach($sql as $key){
            if($key->id!=$lastid){
                $semester=Semesteryears::findOrFail($key->id);
                $semester->use='0';
                $semester->save();
            }


        }
       // $upda=DB::update('update semester_year set use=0 where id != ?',array($lastid));
		//Semesteryears::create($request->all());
		return redirect('semesteryear');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$semesteryear = Semesteryears::findOrFail($id);
		return view('semesteryear.show', compact('semesteryear'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$semesteryear = Semesteryears::findOrFail($id);
		return view('semesteryear.edit', compact('semesteryear'));
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
        $semester=Semesteryears::findOrFail($id);
//        dd($semester);
//        $semester->semester=$request->get('semester');
//        $semester->year=$request->get('year');
        $semester->use=$request->get('use');
        $semester->save();
        //$update=DB::update('update semester_year set use=0 where id<>?',array($id));
//        $semesteryear = Semesteryears::findOrFail($id);
//		$semesteryear->update($request->all());
        if($request->get('use')=='1') {
            $sql = DB::select('select * from semester_year');
            foreach ($sql as $key) {
                if ($key->id != $id) {
                    $semester = Semesteryears::findOrFail($key->id);
                    $semester->use = '0';
                    $semester->save();
                }


            }
        }
		return redirect('semesteryear');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Semesteryears::destroy($id);
		return redirect('semesteryear');
	}

}