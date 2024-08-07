<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Models\Marketing;
use App\Models\Admin;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\History;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller {
    private function get_client_ip() {
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

    private function createHistoryUser($user_id,  $user_email, $log, $status){
        $action = "Register : Mitra Aplikasi";
        $environment = App::environment();
        $isDebug = config('app.debug');
        $ip_testing = "125.164.244.223";
        $ip_production = $this->get_client_ip();
        $PublicIP = "";
        $lat = "";
        $long = "";
        $user_location = "";
        if ($environment === 'production' && !$isDebug) {
            $PublicIP = $ip_production;
        } else if ($environment === 'local' && $isDebug) {
            $PublicIP = $ip_testing;
        }

        if(!is_null($PublicIP) || !empty($PublicIP)){
            $getLoc = Location::get($PublicIP);
            if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                $lat = $getLoc->latitude;
                $long = $getLoc->longitude;
                $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";
            }
        }

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

    public function create(): View {
        return view('marketing.auth.register');
    }

    public function store(Request $request): RedirectResponse {
        DB::connection()->enableQueryLog();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            // 'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'alamat' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $marketing = Marketing::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if(!is_null($marketing)) {
            $marketing->detailMarketingStore($marketing);
            $marketing->createWallet($marketing);
        }

        event(new Registered($marketing));

        Auth::guard('marketing')->login($marketing);

        $login_id = NULL;
        $login_email = $request->email;
        $this->createHistoryUser($login_id, $login_email, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

        return redirect(RouteServiceProvider::MARKETING_DASHBOARD);
    }
}
