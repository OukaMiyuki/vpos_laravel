<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller {
    public function emailVerificationView(Request $request): RedirectResponse|View {
        // return $request->user()->hasVerifiedEmail()
        //             ? redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD)
        //             : view('marketing.auth.verify-email');
        return $request->user()->hasVerifiedEmail()
                        ? redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD)
                        : view('marketing.auth.otp');
    }
}
