<?php

namespace Corp\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $loginView;

    // protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');

        $this->loginView = env('THEME') . '.login';
    }

    public function showLoginForm() {
        $view = property_exists($this, 'loginView') ? $this->loginView : '';

        if (view()->exists($view)) {
            return view($view)->with('title', 'Вход на сайт');
        }
        abort(404);
    }

    public function username() {
        $login = request()->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        
        request()->merge([$field => $login]);
        
        return $field;
    }

    protected function redirectTo() {
        return '/admin';
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

}
