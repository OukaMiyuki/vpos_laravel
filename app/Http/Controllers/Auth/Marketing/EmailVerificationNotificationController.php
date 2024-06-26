<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller {
    public function store(Request $request): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
        }

        $request->user()->sendEmailVerificationNotification();
        $notification = array(
            'message' => 'Kode OTP telah dikirim ke Email!',
            'alert-type' => 'success',
        );
        // return back()->with('status', 'verification-link-sent');
        return back()->with($notification);
    }
}
