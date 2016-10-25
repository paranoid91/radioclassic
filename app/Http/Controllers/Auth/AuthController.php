<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\User;

use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo = 'is-admin/articles';


    /**
     * User role id
     * @var Registrar
     */
    protected $role_id;

    /**
     * AuthController constructor.
     * @param Guard $auth
     * @param Registrar $registrar
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->middleware('guest', ['except' => ['getLogout','newLogout','newLogin','checkLogin']]);
    }


    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'passport' => $data['passport'],
            'phone' => $data['phone']
        ]);
    }


    /**
     * adding user role
     * @param array $data
     */
    public function addRole(array $data){
        $user = User::find($data['user_id']);
        $this->role_id = ($data['role_id'] > 0) ? $data['role_id'] : $data['default'];
        $user->roles()->attach($this->role_id);
    }


    /**
     * Checking Ajax Login
     */
    public function checkLogin(Request $request){
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            if($request->ajax())
            {
                return $validator->getMessageBag()->toJson();
            } else{
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }
       // $error = array('error'=>trans('all.error_login'));
        $success = array('success'=>trans('all.success_login'));
        //$loginStatus = $this->validateUserLogin($request->all());
        $loginStatus = $this->auth->attempt($request->only('email','password'));
        if($loginStatus){
            return $success;
        }else{
            return 2;
        }

    }


    /**
     *  User Registration
     */

    public function registration(Request $request){
        $validator =  $this->userValidator($request->all());
        if($validator->fails()){
            if($request->ajax())
            {
                return $validator->getMessageBag()->toJson();
            } else{
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }else{
            $user = $this->create($request->all());
            if($user->id > 0){
                $this->addRole(['user_id'=>$user->id,'role_id'=>3,'default'=>3]);
                $this->auth->login($user);
                $success = array('success'=>trans('all.success_login'));
                return $success;
            }else{
                $error = array('error'=>trans('all.error_data'));
                return $error;
            }
        }
    }


    /**
     * @param array $data
     * @return mixed
     * User Validation while registering
     */
    public function userValidator(array $data)
    {
        return Validator::make($data, [
            'name' => "required|max:255|regex:~^(?:[\p{L}\p{Mn}\p{Pd}\'\x{2019}]+\s[\p{L}\p{Mn}\p{Pd}\'\x{2019}]+\s?)+$~u",
            'passport' => 'required|max:20',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function newLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
        return view('admin.auth.login');
    }
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function newLogout()
    {
        $this->auth->logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
