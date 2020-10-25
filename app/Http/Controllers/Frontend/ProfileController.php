<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller as BaseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{

    function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    public function profile()
    {
        $user = Auth::user();

        if (request()->isMethod('POST')) {

            $request = request()->all();

            $rules = [
                'name' => 'required',
            ];

            $validator = Validator::make($request, $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator, 'profile')->withInput();
            }

            if (!empty(request()->input('username'))) {
                if (!$user->checkUsername(request()->input('username'))) {
                    $user->username = request()->input('username');
                }
            } else {
                $user->username = null;
            }

            if (!empty(request()->input('birthday'))) {
                $user->birthday = request()->input('birthday'); //Carbon::createFromFormat(trans('globals.date_format'),  request()->input('birthday'))->format('Y-m-d');
            }

            $user->name = request()->input('name');

            if (!empty(request()->input('image'))) {
                $user->image = request()->input('image');
            }

            $user->save();

            Session::flash('success', 'Profile updated');

            return redirect(route_locale('frontend.profile.index'));
        }


        return view('frontend.pages.profile')->with('user', $user);
    }

    public function editPassword()
    {
        $user = Auth::user();

        if (request()->isMethod('POST')) {

            $current_password = request()->input('current_password');
            $new_password = request()->input('new_password');
            $new_password_verify = request()->input('new_password_verify');

            if (empty($new_password) || $new_password != $new_password_verify) {
                Session::flash('error', 'Passwords do not match');
                return back();
            }

            if (!is_null($user->password)) {

                if (Hash::check($current_password, $user->password)) {
                    Session::flash('error', 'Current password is not true');
                    return back();
                }
            }

            $user->password = Hash::make($new_password);

            $user->save();

            Session::flash('success', 'Password updated');

            return redirect(route_locale('frontend.change-password'));

        }

        return view('frontend.pages.profile_edit_password')
            ->with('user', $user);
    }

    public function myFavorites()
    {
        $user = Auth::user();

        $favorites = $user->favorites()->get();

        return view('frontend.pages.profile_favorites_list')
            ->with('favorites', $favorites);
    }

    public function myIssues()
    {
        $user = Auth::user();

        $issues = $user->issues()->get();

        return view('frontend.pages.profile_issues_list')
            ->with('issues', $issues);
    }

    public function login()
    {
        return redirect('/');
    }

}
