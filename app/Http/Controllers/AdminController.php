<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function managementPage()
    {
        $page_name = 'Admin';
        $sub_name = 'Management';
        return view('admin.management', compact('page_name', 'sub_name'));
    }

    public function managementPageWithSearchResult(Request $request)
    {
        $page_name = 'Admin';
        $sub_name = 'Management';

        $validator = \Validator::make($request->all(),[
            'search_user_filter' => 'required',
            'search_criteria_filter' => 'required',
            'search_value' => 'required'
        ]);

        if($validator->fails()){
            return redirect(url('admin'))
                ->withErrors($validator);
        }

        $resultSearchUser = User::all();

        return view('admin.management', compact('page_name', 'sub_name', 'resultSearchUser'));
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
