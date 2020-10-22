<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Services\SocialFacebookAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthFacebookController
{

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialFacebookAccountService $service)
    {

        $facebookUser = Socialite::driver('facebook')->user();

        $user = $service->createOrGetUser($facebookUser);

        auth()->login($user);

        return redirect()->to('/');
    }
}
