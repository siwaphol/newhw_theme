<?php namespace App\Http\Controllers\Auth;
//
//use App\User;
//use App\Http\Controllers\Controller;
//use Illuminate\Contracts\Auth\Guard;
//
//use App\Http\Requests\Auth\LoginRequest;
//use App\Http\Requests\Auth\RegisterRequest;
//
//class AuthController extends Controller {
//
//    /**
//     * the model instance
//     * @var User
//     */
//    protected $user;
//    /**
//     * The Guard implementation.
//     *
//     * @var Authenticator
//     */
//    protected $auth;
//
//
//    /**
//     * @param Guard $auth
//     * @param User $user
//     */
//    public function __construct(Guard $auth, User $user)
//    {
//        $this->user = $user;
//        $this->auth = $auth;
//
//        $this->middleware('guest', ['except' => ['getLogout']]);
//    }
//
//    /**
//     * Show the application registration form.
//     *
//     * @return Response
//     */
//    public function getRegister()
//    {
//        return view('auth.register');
//    }
//
//    /**
//     * Handle a registration request for the application.
//     *
//     * @param  RegisterRequest  $request
//     * @return Response
//     */
//    public function postRegister(RegisterRequest $request)
//    {
//        $this->user->email = $request->email;
//        $this->user->password = bcrypt($request->password);
//        $this->user->save();
//
//        //code for registering a user goes here.
//        $this->auth->login($this->user);
//        return redirect('/');
//    }
//
//    /**
//     * Show the application login form.
//     *
//     * @return Response
//     */
//    public function getLogin()
//    {
//        return view('auth.login');
//    }
//
//    /**
//     * Handle a login request to the application.
//     *
//     * @param  LoginRequest  $request
//     * @return Response
//     */
//    public function postLogin(LoginRequest $request)
//    {
//        require_once('/Itsc/Itscapi.php');
//        $sauth = authen_with_ITSC_api('siwaphol_boonpan', 'siwaphol01');
//        if ($sauth->success == true)
//        {
////            dd('ITSC First Authen is complete' . $sauth->ticket->access_token);
//            $sinfo = get_student_info('siwaphol_boonpan',$sauth->ticket->access_token);
//            dd($this->auth);
//            dd($sinfo);
//            return redirect('/');
//        }
//
//        return redirect('/login')->withErrors([
//            'email' => 'The credentials you entered did not match our records. Try again?',
//        ]);
//    }
//
//    /**
//     * Log the user out of the application.
//     *
//     * @return Response
//     */
//    public function getLogout()
//    {
//        $this->auth->logout();
//
//        return redirect('/');
//    }
//
//}

//=================================================
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

//	use AuthenticatesAndRegistersUsers;

    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The registrar implementation.
     *
     * @var \Illuminate\Contracts\Auth\Registrar
     */
    protected $registrar;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->auth->login($this->registrar->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
//            dd($this->redirectPath());
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath'))
        {
            return $this->redirectPath;
        }

       // return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/index';
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }


}
