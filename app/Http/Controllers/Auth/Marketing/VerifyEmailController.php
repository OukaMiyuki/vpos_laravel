<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use App\Models\Marketing;

class VerifyEmailController extends Controller {
    public function verificationProcess(EmailVerificationRequest $request): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD.'?verified=1');
    }

    public function processVerification(Request $request){
        if(!empty(auth()->user()->email_verified_at) || !is_null(auth()->user()->email_verified_at) || auth()->user()->email_verified_at != NULL || auth()->user()->email_verified_at != "") {
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
        } else {
            $kode = (int) $request->first.$request->second.$request->third.$request->fourth.$request->fifth.$request->sixth;
            $otp = (new Otp)->validate(auth()->user()->email, $kode);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                // event(new Verified(auth()->user()));
                // return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
                // return auth()->user()->email;
                $user = Marketing::where('email', auth()->user()->email)->first();
                $user->markEmailAsVerified();
                // return $user;
                return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
                // $user->update([
                //     'email_verified_at' => now()
                // ]);
                // return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
            }
        }
    }
}
