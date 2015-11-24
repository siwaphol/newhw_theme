<?php namespace App\Http\Controllers\Auth\Itsc;

class Itscapi {

//    protected $jsonHandler;

    public function __construct()
    {
//        $this->jsonHandler = new JsonHandler();
    }

    public static function authen_with_ITSC_api($user_name,$password){

        // *** $email should not contains @cmu.ac.th ***
        //IMPORTANT
        //Deprecated version 1
        //$url="https://account.cmu.ac.th/v1/api/validateUser?appId=575cb268-e295-40fc-91f3-69e7d239dc24&appSecret=m4Fg4d8ePk&user=" .$user_name."&pw=".$password;
        $url = "https://account.cmu.ac.th/v3/api/validateUser";

        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"appId: d972d6e4-41d1-4f66-8946-cf3599fe1c24\r\n" .
                    "appSecret: Okd41Fs2ed\r\n" .
                    "user: $user_name\r\n" .
                    "pw: $password\r\n"
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($url , false, $context);
        $test =  json_decode($result);

        return json_decode($result); // Return an object

    }

    public static function  get_student_info($user_name,$access_token){
        //IMPORTANT must be "accees_token" not access_token in url GET parameter

        //$url="https://account.cmu.ac.th/v1/api/Students/" . $user_name . "?appId=575cb268-e295-40fc-91f3-69e7d239dc24&appSecret=m4Fg4d8ePk&accees_token=" . $access_token;
        $url = "https://account.cmu.ac.th/v3/api/students";

        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"appId: d972d6e4-41d1-4f66-8946-cf3599fe1c24\r\n" .
                    "appSecret: Okd41Fs2ed\r\n" .
                    "userName: $user_name\r\n" .
                    "access_token: $access_token\r\n"
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($url , false, $context);

        return json_decode($result);
    }

    public static function  get_employee_info($user_name,$access_token){
        //IMPORTANT must be "accees_token" not access_token in url GET parameter
        //$url="https://account.cmu.ac.th/v1/api/Employees/" . $user_name . "?appId=575cb268-e295-40fc-91f3-69e7d239dc24&appSecret=m4Fg4d8ePk&accees_token=" . $access_token;
        $url = "https://account.cmu.ac.th/v3/api/employees";

        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"appId: d972d6e4-41d1-4f66-8946-cf3599fe1c24\r\n" .
                    "appSecret: Okd41Fs2ed\r\n" .
                    "userName: $user_name\r\n" .
                    "access_token: $access_token\r\n"
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($url , false, $context);

        return json_decode($result);
    }

    public static function ITSC_logout($user_name,$access_token){
        //IMPORTANT must be "accees_token" not access_token in url GET parameter
        //$url="https://account.cmu.ac.th/v1/api/Logout/" . $user_name . "?appId=575cb268-e295-40fc-91f3-69e7d239dc24&appSecret=m4Fg4d8ePk&accees_token=" . $access_token;
        $url = "https://account.cmu.ac.th/v3/api/logout";

        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"appId: d972d6e4-41d1-4f66-8946-cf3599fe1c24\r\n" .
                    "appSecret: Okd41Fs2ed\r\n" .
                    "userName: $user_name\r\n" .
                    "access_token: $access_token\r\n"
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($url , false, $context);

        return json_decode($result);
    }


}
//include('JsonHandler.php');
