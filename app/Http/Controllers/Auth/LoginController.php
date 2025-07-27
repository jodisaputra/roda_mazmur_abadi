<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Enums\RoleEnum;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Menggunakan Spatie hasRole method
        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return redirect('/admin');
        }

        if ($user->hasRole(RoleEnum::TENANT->value)) {
            return redirect('/tenant');
        }

        if ($user->hasRole(RoleEnum::CUSTOMER->value)) {
            return redirect('/customer');
        }

        if ($user->hasRole(RoleEnum::GUEST->value)) {
            return redirect('/guest');
        }

        return redirect('/home');
    }
}
