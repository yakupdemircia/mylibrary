<?php

namespace App\Http\Controllers\Panel;

use Auth;
use Validator;

class AuthController
{
    public function getLoginPage()
    {
        return view('panel.login');
    }

    public function doLogin()
    {

        if (Auth::guard('admin')->check()) {
            return redirect('/panel/home');
        }

        if (request()->isMethod('POST')) {
            $rules = [
                'email'    => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make(request()->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator, 'login')->withInput();
            }

            if (Auth::guard('admin')->attempt(['email' => request()->input('email'), 'password' => request()->input('password')])) {
                return redirect('/panel/home');
            } else {
                return redirect()->back()->withInput();
            }
        }

        return view('panel.login');
    }


    public function doLogout()
    {
        Auth::logout();
        return redirect('/panel');
    }


}
