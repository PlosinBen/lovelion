<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    private array $socialProvider = [
        'facebook',
    ];

    public function login()
    {
        return $this->view('member.login');
    }

    public function loginSocial(string $provider, Request $request)
    {
        $path = request()->get('path');
        if (env('APP_ENV') === 'local') {
            auth()->loginUsingId(1);

            return redirect($path);
        }

        session(['login_refer' => $path]);

        return Socialite::driver($provider)
            ->redirectUrl(route('login.callback', $provider))
            ->redirect();
    }

    public function callback($provider)
    {
    }
}
