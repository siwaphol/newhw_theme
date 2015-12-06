<?php

namespace App\Http\Controllers;

use App\Semesteryears;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AutomateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function firstTimeWizard()
    {
        // Support 2 year backward and 5 year ahead
        $year_backward = 2;
        $year_ahead = 5;

        // Return array for year and semester
        $all_semester_and_year = Semesteryears::orderBy('year', 'DESC')->orderBy('semester')->get();
        $ys_arr = array();
        foreach($all_semester_and_year as $semester_year){
            $current_semester = $semester_year->semester;
            $current_year = $semester_year->year;
            array_push($ys_arr,
                ["year" => $current_year , "semester" => $current_semester
                    , "selected" => (\Session::get('semester')===$current_semester && \Session::get('year')===$current_year)?true:false]);
        }
        // Get current Year and make list of year backward and ahead
        $current_year = Semesteryears::where('use','1')->first()->year;
        $year_range = [];
        for($i=$year_backward; $i>0; $i--){
            array_push($year_range, $current_year-$i);
        }
        array_push($year_range, $current_year-0);
        for($i=1; $i<=$year_ahead; $i++){
            array_push($year_range, $current_year+$i);
        }

//        dd($year_range);
        return view('automate.first_time_wizard', compact('ys_arr','year_range'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
