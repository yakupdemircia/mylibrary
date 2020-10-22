<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Services\SocialGoogleAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthGoogleController
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(SocialGoogleAccountService $service)
    {
        $googleUser = Socialite::driver('google')->user();

        $user = $service->createOrGetUser($googleUser);

        auth()->login($user);

        return redirect()->to('/');
    }
}
