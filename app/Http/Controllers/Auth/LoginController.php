<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // login function on the base of username and password
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'user_name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9]+([ -@_][a-zA-Z0-9]+)*$/'],
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        $credentials = $request->only('user_name', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/home');
        }

        // Authentication failed
        return back()->withErrors(['user_name' => 'Invalid credentials']);
    }
    
    /**
         * Logout trait
         *
         * @author Yugo <dedy.yugo.purwanto@gmail.com>
         * @param  Request $request
         * @return void
    */
    protected function logout(Request $request)
    {
        $this->guard()->logout(); //authentication guard used by the application, like web, api

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login');
    }
}
