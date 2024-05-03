<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Ichtrojan\Otp\Otp;

class VerifyEmailController extends Controller {
    public function verificationProcess(EmailVerificationRequest $request): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD.'?verified=1');
    }

    public function processVerification(Request $request){
        if(!empty(auth()->user()->email_verified_at) || !is_null(auth()->user()->email_verified_at) || auth()->user()->email_verified_at != NULL || auth()->user()->email_verified_at != "") {
            return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD);
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
                $user = Tenant::where('email', auth()->user()->email)->first();
                $user->markEmailAsVerified();
                $notification = array(
                    'message' => 'Verifikasi OTP Email Berhasil!',
                    'alert-type' => 'success',
                );
                return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD)->with($notification);
            }
        }
    }
}
