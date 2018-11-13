<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected function validateName($name)
    {
        return preg_match('/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u', $name);
    }

    protected function username()
    {
        $username = request()->get('username');

        $map = [
            'email' => filter_var($username, FILTER_VALIDATE_EMAIL),
            'name' => $this->validateName($username),
        ];
        $field=key(array_filter($map)) ?? 'name';
        request()->merge([$field => $username]);
        return $field;
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
