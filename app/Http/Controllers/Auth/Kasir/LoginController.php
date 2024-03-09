<?php

namespace App\Http\Controllers\Auth\Kasir;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    public function create(): View {
        return view('kasir.auth.login');
    }

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if(! Auth::guard('kasir')->attempt($request->only('email', 'password'), $request->boolean('remember')))
        {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        $notification = array(
            'message' => 'Anda berhasil login!',
            'alert-type' => 'success',
        );
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::KASIR_DASHBOARD)->with($notification);
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('kasir')->logout();

        $request->session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/kasir/login');
    }
}
