<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Arahkan pengguna berdasarkan peran (role) mereka
        if ($user->role === 'ketua') {
            return redirect()->route('ketua.dashboard');
        } elseif ($user->role === 'panitia') {
            return redirect()->route('panitia.dashboard');
        } elseif ($user->role === 'bendahara') {
            return redirect()->route('bendahara.dashboard.index');
        }

        // Jika peran tidak dikenali, arahkan ke rute default
        return redirect()->intended($this->redirectPath());
    }
}