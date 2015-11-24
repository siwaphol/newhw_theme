<?php //namespace App\Http\Controllers;
//
//use App\Http\Requests\Formadmin;
//use App\Http\Controllers\Controller;
//
//use App\Admins;
//use App\User;
//use Illuminate\Http\Request;
//use Carbon\Carbon;
//use DB;
//
//class AdminController extends Controller
//{
//
//    /**
//     * Display a listing of the resource.
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        //$admins = Admins::latest()->get();
//        $admins = DB::select('select * from users where role_id=1000');
//        return view('admin.index', compact('admins'));
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        return view('admin.create');
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @return Response
//     */
//    public function store(Formadmin $request)
//    {
//        $findid = DB::select('select max(id) as maxid from users where role_id=1000 or role_id=0100');
//
//        $id = intval($findid[0]->maxid);
//        $id += 1;
//        $id = str_pad($id, 9, "0", STR_PAD_LEFT);
//
//        $username = $request->get('username');
//        $firstname_th = $request->get('firstname_th');
//        $firstname_en = $request->get('firstname_en');
//        $lastname_th = $request->get('lastname_th');
//        $lastname_en = $request->get('lastname_en');
//        $email = $request->get('email');
//
//        $teacher = DB::insert('insert into users (id,username,role_id,firstname_th,firstname_en,lastname_th,lastname_en,email)values(?,?,1000,?,?,?,?,?)', array($id, $username, $firstname_th, $firstname_en, $lastname_th, $lastname_en, $email));
//
//        //$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
//        //Admins::create($request->all());
//        return redirect('admin');
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int $id
//     * @return Response
//     */
//    public function show($id)
//    {
//        $admin = DB::select('select * from users where id=?', array($id));
//        return view('admin.show', compact('admin'));
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int $id
//     * @return Response
//     */
//    public function edit($id)
//    {
//        $admin = DB::select('select * from users where id=?', array($id));
//        return view('admin.edit', compact('admin'));
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int $id
//     * @return Response
//     */
//    public function update(Formadmin $request)
//    {
//        $id = $request->get('id');
//        $username = $request->get('username');
//        $firstname_th = $request->get('firstname_th');
//        $firstname_en = $request->get('firstname_en');
//        $lastname_th = $request->get('lastname_th');
//        $lastname_en = $request->get('lastname_en');
//        $email=$request->get('email').'@cmu.ac.th';
//        $update = DB::update('update users set username=?,firstname_th=?,firstname_en=?,lastname_th=?,lastname_en=?,email=? where id=?', array($username, $firstname_th, $firstname_en, $lastname_th, $lastname_en, $email, $id));
//
//        return redirect('admin');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        $admin = DB::delete('delete from users where id=?', array($id));
//        return redirect('admin');
//    }
//
//    public function assign()
//    {
//        $admin = DB::select('select * from users where role_id = 0100');
//        $teacher = DB::select('select * from users where role_id = 1000');
//        return view('admin.assign', compact('admin','teacher'));
//    }
//
//    public function saveassign()
//    {
//        $adminid = $_POST['adminid'];
//        $type=$_POST['type'];
//        if($type==1){
//            $ad=User::findorfail($adminid);
//            $ad->role_id='0100';
//            $ad->save();
//            //$insert = DB::update('update users set role_id=1000 where id=?', array($adminid));
//            return redirect('admin');
//        }
//        if($type==0){
//            $ad=User::findorfail($adminid);
//            $ad->role_id='1000';
//            $ad->save();
//            //$insert = DB::update('update users set role_id=0100 where id=?',array($adminid));
//            return redirect('admin');
//        }
//
//    }
//}