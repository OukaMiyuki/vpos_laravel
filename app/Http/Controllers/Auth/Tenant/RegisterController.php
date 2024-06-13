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
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Models\History;
use Illuminate\Database\Query\Builder;

class RegisterController extends Controller {

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function create(): View {
        return view('tenant.auth.register');
    }

    public function store(Request $request): RedirectResponse {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
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

        if($invitationcodeid->is_active == 0){

            $notification = array(
                'message' => 'Invitation code tidak bisa digunakan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_inv_code' => $invitationcodeid->id
        ]);

        $randomString = Str::random(30);

        // Auth::guard('tenant')->login($tenant);

        // return redirect(RouteServiceProvider::TENANT_DASHBOARD);

        if(!is_null($tenant)) {
            $tenant->detailTenantStore($tenant);
            $tenant->fieldInsert($randomString);
            $tenant->storeInsert($tenant, $randomString);
            $tenant->createWallet($tenant);
        }

        event(new Registered($tenant));

        Auth::guard('tenant')->login($tenant);

        History::create([
            'id_user' => NULL,
            'email' => $request->email,
            'action' => "Register Tenant : Success!",
            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
            'deteksi_ip' => $ip,
            'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
            'status' => 1
        ]);

        return redirect(RouteServiceProvider::TENANT_DASHBOARD);
    }

    public function createMitra(): View {
        return view('tenant.auth.register_mitra');
    }

    public function storeMitra(Request $request): RedirectResponse {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
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
        ]);

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_inv_code' => 0
        ]);

        if(!is_null($tenant)) {
            $tenant->detailTenantStore($tenant);
            $tenant->createWallet($tenant);
        }

        event(new Registered($tenant));

        Auth::guard('tenant')->login($tenant);

        History::create([
            'id_user' => NULL,
            'email' => $request->email,
            'action' => "Register Tenant Mitra Bisnis : Success!",
            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
            'deteksi_ip' => $ip,
            'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
            'status' => 1
        ]);

        return redirect(RouteServiceProvider::TENANT_MITRA_DASHBOARD);
    }
}
