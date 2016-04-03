<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(strpos($request->input('only'), 'teacher')!==false){
            $users = User::teacher()->get();
        }
        else if(strpos($request->input('only'), 'admin')!==false){
            $users = User::admin()->get();
        }
        else if(strpos($request->input('only'), 'ta')!==false){
            $users = User::ta()->get();
        }
        else if(strpos($request->input('only'), 'student')!==false){
            $users = User::student()->get();
        }
        else{
            $users = User::all();
        }

        return $users;
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
        $user = User::find($id);

        if(is_null($user)){
            return json_encode(['success'=>false, 'message'=>'Not found user with id '.$id]);
        }

        if($request->input('opt')==='add_admin'){
            $user->changeRole(array_merge($user->getRoleArray(), [User::ADMIN_ROLE]));
            $user->save();
        }

        //TODO-nong หน้า front-end เตือน user ด้วยว่าถ้ามีแค่ admin role อย่างเดียว จะทำให้ user ไม่มี role เหลืออยู่แล้ว
        if($request->input('opt')==='del_admin'){
            $temp = $user->role_id;
            $temp[0] = '0';
            $user->role_id = $temp;
            $user->save();
        }

        return json_encode(['success'=>true, 'data'=>$user]);
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
