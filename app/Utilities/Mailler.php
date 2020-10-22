<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Mail;

class Mailler
{

    public function sendTestMail()
    {

        Mail::send("frontend.mail.test", ["name" => "Deneme"], function ($message) {
            $message->to("demirciyakupkadri@gmail.com", "Yak Dem")->subject("welcome");
        });

    }

    public function sendPasswordResetMail($user)
    {

        Mail::send("frontend.mail.password_reset", ['user' => $user], function ($m) use($user) {

            $subject = trans('mail.subject.password_reset');

            $m->to($user->email, $user->name)->subject($subject);
        });


    }


}
