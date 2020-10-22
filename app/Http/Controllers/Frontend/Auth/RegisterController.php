<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register()
    {
        $validation = $this->validator(request()->all());
        if ($validation->fails()) {
            return response()->json($validation->errors()->toArray());
        } else {

            //create user
            $user = $this->create(request()->all());

            //send verification email
            try {
                $user->sendEmailVerificationNotification();
            } catch (\Error $e) {

            }

            //auto login user
            Auth::login($user);

            if ($user) {
                return response()->json([
                    'result'  => 'success',
                    'message' => __('auth.registration successful'),
                ]);
            } else {
                return response()->json([
                    'result'  => 'error',
                    'message' => __('auth.registration failed'),
                ]);
            }


        }
    }
}
