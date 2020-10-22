<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return response()->json([
                'result'  => 'error',
                'message' => __('auth.eposta doğrulanmış'),
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'result'  => 'success',
            'message' => __('auth.verification code sent'),
        ]);
    }

    public function verify(Request $request)
    {
        if (!hash_equals((string)$request->route('id'), (string)$request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            $request->session()->regenerate();

            return redirect($this->redirectPath())->with('verified', 2);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $request->session()->regenerate();

        return redirect($this->redirectPath())->with('verified', 1);
    }
}
