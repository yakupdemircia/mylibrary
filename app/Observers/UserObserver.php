<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "saving" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        $user->card_id = ($user->id + getenv('USER_ID_START'));
    }

    public function updating(User $user)
    {
        $user->card_id = ($user->id + getenv('USER_ID_START'));
    }

    /**
     * Handle the user "saving" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->card_id = ($user->id + getenv('USER_ID_START'));
    }
}
