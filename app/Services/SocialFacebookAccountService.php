<?php

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {

        if ($account = User::where('facebook_id', $providerUser->getId())->first()) {
            return $account;
        } else {

            $email = $providerUser->getEmail();

            $user = User::withTrashed()->where('email', trim($email))->first();

            if (!$user) {

                $data = [
                    'email'       => $providerUser->getEmail(),
                    'name'        => $providerUser->getName(),
                    'facebook_id' => $providerUser->getId(),
                    'password'    => md5(rand(1, 10000)),
                ];

                $user = User::create($data);

            } else {
                $user->facebook_id = $providerUser->getId();
                $user->save();
            }

            return $user;
        }
    }
}
