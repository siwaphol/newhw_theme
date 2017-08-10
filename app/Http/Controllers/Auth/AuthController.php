<?php namespace App\Http\Controllers\Auth;
use App\Course;
use App\Http\Controllers\Controller;
use App\Semesteryears;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Validator;
use Auth;
use Socialite;

class AuthController extends Controller {

    protected $auth;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

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

    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return redirect('oauth/login');
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
//
        $credentials = $request->only('email', 'password');

//        if (!is_null(Auth::attempt($credentials, $request->has('remember'))))
//        {
//            return redirect()->intended($this->redirectPath());
//        }
        //Nong test
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request);
        }
        //End Nong test

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    //Nong test
    protected function handleUserWasAuthenticated(Request $request)
    {
        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        return redirect()->intended($this->redirectPath());
    }
    //End Nong test
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
        Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/oauth/login');
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

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/index';
    }

    public function redirectToProvider()
    {
        return Socialite::driver('cmu')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('cmu')->user();
        $credentials = array('email'=>$user->username, 'password'=>null);

        $systemUser = User::find($user->id);
        $semesterYear = Semesteryears::where('use', 1)->first();
        if ($systemUser){
        	$systemUser->username = $user->username;
        	$systemUser->firstname_th = $user->firstname_th;
        	$systemUser->firstname_en = $user->firstname_en;
        	$systemUser->lastname_th = $user->lastname_th;
        	$systemUser->lastname_en = $user->lastname_en;
        	if (is_null($systemUser->semester) || is_null($systemUser->year)){
        		$systemUser->semester = $semesterYear->semester;
        		$systemUser->year = $semesterYear->year;
	        }
	        $systemUser->save();
        }

        if (Auth::attempt($credentials, null)) {
        	return redirect("/");
        }

        //TODO-nong handle Unsuccessful login
	    return redirect("/");
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/oauth/login';
    }


}
