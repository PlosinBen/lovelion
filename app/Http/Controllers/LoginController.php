<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    private array $socialProvider = [
        'facebook',
    ];

    public function login(Request $request)
    {
        return $this->view('member.login')
            ->withCookie('login_refer', $request->get('path'));
    }

    public function loginSocial(string $provider)
    {
        if (env('APP_ENV') === 'local') {
            auth()->loginUsingId(1);

            return $this->redirectToReferPage();
        }

        return Socialite::driver($provider)
            ->redirectUrl(route('login.callback', $provider))
            ->redirect();
    }

    public function callback($provider, UserService $userService)
    {
        $user = Socialite::driver($provider)->user();

        $user = $userService->getBySocialUser($provider, $user);

        if ($user === null) {
            //register?

            return;
        }

        auth()->login($user);

        return redirect('/');
    }

    private function redirectToReferPage()
    {
        $target = Cookie::get('login_refer') ?? route('admin.dashboard');
        Cookie::queue('login_refer', '', -1);

        return redirect($target);
    }
}
