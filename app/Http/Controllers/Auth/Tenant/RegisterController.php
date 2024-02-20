<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Models\Tenant;
use App\Models\Marketing;
use App\Models\Admin;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\InvitationCode;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class RegisterController extends Controller {
    
    public function create(): View {
        return view('tenant.auth.register');
    }

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'alamat' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
            'inv_code' => ['required', Rule::exists('invitation_codes')->where(function ($query) {
                            return $query->where('inv_code', request()->get('inv_code'));
                        })],
        ]);

        $invitationcodeid = InvitationCode::where('inv_code', $request->inv_code)->first();

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_inv_code' => $invitationcodeid->id
        ]);

        // Auth::guard('tenant')->login($tenant);

        // return redirect(RouteServiceProvider::TENANT_DASHBOARD);

        if(!is_null($tenant)) {
            $tenant->detailTenantStore($tenant);
            $tenant->storeInsert($tenant);
        }

        event(new Registered($tenant));
                
        Auth::guard('tenant')->login($tenant);

        return redirect(RouteServiceProvider::TENANT_DASHBOARD);

        // $notification = array(
        //     'message' => 'Akun anda sukses dibuat!',
        //     'alert-type' => 'info',
        // );

        // return redirect(route('tenant.login'))->with($notification);
    }
}
