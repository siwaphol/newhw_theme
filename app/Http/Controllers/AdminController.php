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

        $admins = User::admin()
            ->currentSemester()
            ->get();

        $successMessage = '';
        if(\Session::has('successMessage')){
            $successMessage = \Session::get('successMessage');
        }

        return view('admin.management', compact('page_name', 'sub_name', 'admins', 'successMessage'));
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
            case User::SEARCH_CRITERIA_ID:
                $resultSearchUser->where('id', 'LIKE', $search_value);
                break;
        }

        $resultSearchUser = $resultSearchUser->get();
        $admins = User::admin()
            ->currentSemester()
            ->get();

        return view('admin.management', compact('page_name', 'sub_name', 'resultSearchUser', 'admins'));
    }

    public function addAdmin(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required'
        ]);

        if($validator->fails()){
//            return response()->json([
//                'message' => $validator->getMessageBag(),
//            ], 404);
            return redirect(url('admin'))
                ->withErrors($validator);
        }

        $user = User::currentSemester()->find($request->input('user_id'));
        if(!$user->isAdmin()){
            $user->changeRole(array_merge($user->getRoleArray(), [User::ADMIN_ROLE]));
            $user->save();
        }
        $successMessage = "successfully assign new admin";
//        return json_encode(['success'=>true, 'message'=>$successMessage]);
        return \Redirect::route('admin')->with('successMessage', $successMessage);
    }

    public function deleteAdmin(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required'
        ]);

        if($validator->fails()){
//            return response()->json([
//                'message' => $validator->getMessageBag(),
//            ], 404);
            return redirect(url('admin'))
                ->withErrors($validator);
        }

        $user = User::currentSemester()->find($request->input('user_id'));
        if($user->isAdmin()){
            $roleArray  = collect($user->getRoleArray());
            $roleArray = $roleArray->reject(function($item){
                return (int)$item===User::ADMIN_ROLE;
            })->all();
            $user->changeRole($roleArray);
            $user->save();
        }
        $successMessage = "successfully remove user id " . $request->input('user_id') . " from admin role";
//        return json_encode(['success'=>true, 'message'=>$successMessage]);
        return \Redirect::route('admin')->with('successMessage', $successMessage);
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
