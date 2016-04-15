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
            'search_criteria_filter' => 'required'
        ]);

        if($validator->fails()){
            return redirect(url('admin'))
                ->withErrors($validator);
        }

        $search_user_filter = (int)$request->input('search_user_filter');
        switch ($search_user_filter){
            case User::TEACHER_ROLE:
                $resultSearchUser = User::teacher()->currentSemester();
                break;
            case User::TA_ROLE:
                $resultSearchUser = User::ta()->currentSemester();
                break;
            case User::STUDENT_ROLE:
                $resultSearchUser = User::student()->currentSemester();
                break;
            default:
                $resultSearchUser = User::excludeAdmin()->currentSemester();
        }

        $search_criteria_filter = (int)$request->input('search_criteria_filter');
        $search_value = "%". $request->input('search_value') . "%";
        switch ($search_criteria_filter){
            case User::SEARCH_CRITERIA_EMAIL:
                $resultSearchUser->where('email', 'LIKE', $search_value);
                break;
            case User::SEARCH_CRITERIA_ENGLISH_NAME:
                $resultSearchUser->where('firstname_en', 'LIKE', $search_value)
                    ->orWhere('lastname_en', 'LIKE', $search_value);
                break;
            case User::SEARCH_CRITERIA_THAI_NAME:
                $resultSearchUser->where('firstname_th', 'LIKE', $search_value)
                    ->orWhere('lastname_th', 'LIKE', $search_value);
                break;
            case User::SEARCH_CRITERIA_USERNAME:
                $resultSearchUser->where('username', 'LIKE', $search_value);
                break;
        }

        $resultSearchUser = $resultSearchUser->get();

        return view('admin.management', compact('page_name', 'sub_name', 'resultSearchUser'));
    }

    public function addAdmin(Request $request)
    {
        $page_name = 'Admin';
        $sub_name = 'Management';

        $validator = \Validator::make($request->all(),[
            'user_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect(url('admin'))
                ->withErrors($validator);
        }

        $user = User::currentSemester()->find((int)$request->input('user_id'));
        if(!$user->isAdmin()){
            $user->changeRole(array_merge($user->getRoleArray(), [User::ADMIN_ROLE]));
        }
        $successMessage = "successfully create assign new admin";

        return view('admin.management', compact('page_name', 'sub_name', 'successMessage'));
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
