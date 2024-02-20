<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller {
        /**
     * Display the email verification prompt.
     */
    public function emailVerificationView(Request $request): RedirectResponse|View {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD)
                    : view('admin.auth.verify-email');
    }
}
