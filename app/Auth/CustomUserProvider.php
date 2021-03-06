<?php namespace App\Auth;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Http\Controllers\Auth\Itsc\Itscapi;
use DB;
use App\User;
use Session;


class CustomUserProvider implements UserProvider {

    protected $model;

    protected $spec_model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function retrieveById($identifier)
    {
        return $this->createModel()->newQuery()->find($identifier);
    }

    public function retrieveByCredentials(array $credentials)
    {
        //set semester and year to session
        $sql=DB::select('select * from semester_year sy where sy.use=1');
        Session::put('semester',$sql[0]->semester);
        Session::put('year',$sql[0]->year);
//        dd($sql);
        Session::forget('course_list');
//        $query = $this->createModel()->newQuery();
//        $query->where('username',$credentials['email']);
//        if($query->count() > 0){
//            if($query->first()->isAdmin() || $query->first()->isTeacher()) {
//                if (!Session::has('course_list')) {
//                    $course_list = $query->first()->getCourseList();
//                    $course_list_str = "";
//                    foreach ($course_list as $course) {
//                        if ($course_list_str === '') {
//                            $course_list_str = $course->course_id;
//                        } else {
//                            $course_list_str = $course_list_str . ',' . $course->course_id;
//                        }
//                    }
//                    Session::put('course_list', $course_list_str);
//
//                }
//            }
//
//            return $query->first();
//        }

        //ITSC authentication use this if run in production
//
        $sauth = Itscapi::authen_with_ITSC_api($credentials['email'], $credentials['password']);

        if ($sauth->success == true)
        {
            $query = $this->createModel()->newQuery();
            $query->where('username',$credentials['email']);

            if($query->first() == null){

                $sinfo = Itscapi::get_student_info($credentials['email'],$sauth->ticket->access_token);
                if($sinfo->success){
                    $qresult = DB::select('select * from course_student where student_id=?',array($sinfo->student->id));
                    $taresult = DB::select('select * from course_ta where student_id=?',array($sinfo->student->id));

                    if(count($qresult) > 0 ){
                        $user = User::find($qresult[0]->student_id);
                        if(count($taresult)>0){
                            $user->role_id = '0011';
                        }
                        $user->username = $credentials['email'];
                        $user->firstname_th = $sinfo->student->firstName->th_TH;
                        $user->firstname_en = strtolower($sinfo->student->firstName->en_US);
                        $user->lastname_th = $sinfo->student->lastName->th_TH;
                        $user->lastname_en = strtolower($sinfo->student->lastName->en_US);
                        $user->email = $credentials['email'] . '@cmu.ac.th';
                        $user->faculty_id = $sinfo->student->faculty->code;
                        $user->save();
                    }else if(count($taresult)>0){
                        $user = new User();
                        $user->id = $sinfo->student->id;
                        $user->username = $credentials['email'];
                        $user->role_id = '0010';
                        $user->firstname_th = $sinfo->student->firstName->th_TH;
                        $user->firstname_en = strtolower($sinfo->student->firstName->en_US);
                        $user->lastname_th = $sinfo->student->lastName->th_TH;
                        $user->lastname_en = strtolower($sinfo->student->lastName->en_US);
                        $user->email = $credentials['email'] . '@cmu.ac.th';
                        $user->faculty_id = $sinfo->student->faculty->code;
                        $user->save();
                    }else{
                        return redirect('/login')->withErrors([
                            'email' => 'No user in database.',
                        ]);
                    }
                }else{
                    $sinfo = Itscapi::get_employee_info($credentials['email'] ,$sauth->ticket->access_token);

                    $qresult = DB::select('select id from users where firstname_en=? and lastname_en=?',array(strtolower($sinfo->employee->firstName->en_US), strtolower($sinfo->employee->lastName->en_US)));
                    if(count($qresult) > 0 ){
                        $user = User::find($qresult[0]->id);
                        $user->username = $credentials['email'];
                        $user->firstname_th = $sinfo->employee->firstName->th_TH;
                        $user->firstname_en = strtolower($sinfo->employee->firstName->en_US);
                        $user->lastname_th = $sinfo->employee->lastName->th_TH;
                        $user->lastname_en = strtolower($sinfo->employee->lastName->en_US);
                        $user->email = $credentials['email'] . '@cmu.ac.th';
                        $user->faculty_id = $sinfo->employee->organization->code;
                        $user->save();
                    }else{
                        return redirect('/login')->withErrors([
                            'email' => 'No user in database.',
                        ]);
                    }
                }

            }

            if($query->first()->isAdmin() || $query->first()->isTeacher()) {
                if (!Session::has('course_list')) {
                    $course_list = $query->first()->getCourseList();
                    $course_list_str = "";
                    foreach ($course_list as $course) {
                        if ($course_list_str === '') {
                            $course_list_str = $course->course_id;
                        } else {
                            $course_list_str = $course_list_str . ',' . $course->course_id;
                        }
                    }
                    Session::put('course_list', $course_list_str);

                }
            }

            return $query->first();
        }
//        return redirect('/login')->withErrors([
//            'email' => 'The credentials you entered did not match our records. Try again?',
//        ]);
        return null;
    }

    protected function findUser($userDetails)
    {

    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
//        $model = $this->createModel();
//
//        return $model->newQuery()
//            ->where($model->getKeyName(), $identifier)
//            ->where($model->getRememberTokenName(), $token)
//            ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
//        $user->setRememberToken($token);
//
//        $user->save();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
//        $plain = $credentials['password'];
//
//        return $this->hasher->check($plain, $user->getAuthPassword());
        return true;
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
//        $name = class_basename($this->model);
//        $name = 'App\\' . $name;

        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

}