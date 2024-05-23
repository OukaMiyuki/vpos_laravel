<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use App\Models\InvitationCode;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\QrisWallet;
use App\Models\Withdrawal;
use App\Models\Rekening;
use App\Models\History;
use Exception;

class MarketingController extends Controller {

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

    public function index(){
        $code = InvitationCode::where('id_marketing', auth()->user()->id)->count();
        $tenant = Marketing::select(['id'])
                            ->withCount('invitationCodeTenant')
                            ->where('id', auth()->user()->id)
                            ->get();
        $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $tenantTerbaru = Marketing::select(['marketings.id'])
                                    ->with(['invitationCodeTenant' => function($query){
                                        $query->select('tenants.id', 'tenants.name', 'tenants.phone', 'tenants.is_active', 'tenants.id_inv_code', 'tenants.created_at')
                                                ->with(['invitationCode' => function($query) {
                                                    $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')->get();
                                                }])->get();
                                    }])
                                    ->where('id', auth()->user()->id)
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                                    
        $pemasukanTerbaru = Marketing::select(['marketings.id'])
                                    ->with(['invitationCodeTenant' => function($query){
                                        $query->select('tenants.id', 'tenants.name', 'tenants.phone', 'tenants.is_active', 'tenants.id_inv_code')
                                                ->with(['withdrawal' => function($query){
                                                    $query->select(['withdrawals.id', 'withdrawals.id_user', 'withdrawals.tanggal_penarikan', 'withdrawals.status'])
                                                            ->with(['detailWithdraw' => function($query){
                                                                $query->select(['detail_penarikans.id', 
                                                                                'detail_penarikans.id_penarikan',
                                                                                'detail_penarikans.biaya_mitra',
                                                                            ])->get();
                                                            }])
                                                            ->where('withdrawals.status', 1)
                                                            ->get();
                                                }
                                                ])->get();
                                    }])
                                    ->where('id', auth()->user()->id)
                                    ->latest()
                                    ->limit(5)
                                    ->get();
        $tenantNumber = "";
        foreach($tenant as $t){
            $tenantNumber = $t->invitation_code_tenant_count;
        }
        return view('marketing.dashboard', compact('code', 'tenantNumber', 'tenantTerbaru', 'qrisWallet', 'pemasukanTerbaru'));
    }

    public function invitationCodeDashboard(){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        } else if(auth()->user()->is_active == 1) {
            $code = InvitationCode::where('id_marketing', auth()->user()->id)->count();
            $invitationCode = InvitationCode::select(['invitation_codes.id', 
                                                        'invitation_codes.id_marketing', 
                                                        'invitation_codes.inv_code', 
                                                        'invitation_codes.holder', 
                                                        'invitation_codes.is_active',
                                                        'invitation_codes.created_at'])
                                            ->with(['tenant' => function($query){
                                                        $query->select(['tenants.id',
                                                                        'tenants.id_inv_code'])
                                                        ->get();
                                                    }
                                            ])
                                            ->where('invitation_codes.id_marketing', auth()->user()->id)
                                            ->orderBy('id', 'DESC')
                                            ->get();
            $tenantCount = Marketing::select(['id'])
                                ->withCount('invitationCodeTenant')
                                ->where('id', auth()->user()->id)
                                ->get();
            $tenantNumber = "";
            foreach($tenantCount as $t){
                $tenantNumber = $t->invitation_code_tenant_count;
            }
            return view('marketing.marketing_invitation_code', compact('invitationCode', 'tenantNumber', 'code'));
        } else {
            if(auth()->check()){
                $notification = array(
                    'message' => 'Account Error, Please contact our aAdmins!',
                    'alert-type' => 'error',
                );
                Auth::guard('marketing')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/marketing/login')->with($notification);
            }
        }
    }

    public function invitationCodeInsert(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
 
        $inv_code = Str::upper($request->code);
        $code_check = InvitationCode::where('inv_code', $inv_code)->first();

        if(!is_null($code_check) || !empty($code_check)){
            $notification = array(
                'message' => 'Kode telah didaftarkan, silahkan buat kode lain!',
                'alert-type' => 'warning',
            );
            
            return redirect()->back()->with($notification);
        }

        InvitationCode::create([
            'id_marketing' => auth()->user()->id,
            'holder' => $request->holder,
            'inv_code' => $inv_code
        ]);

        History::create([
            'id_user' => auth()->user()->id,
            'email' => auth()->user()->email,
            'action' => "Create Invitation Code : Success!",
            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
            'deteksi_ip' => $ip,
            'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
            'status' => 1
        ]);

        $notification = array(
            'message' => 'Kode telah dibuat!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function invitationCodeCashoutList(){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        }else if(auth()->user()->is_active == 1) {
            return view('marketing.marketing_invitation_code_data_penarikan');
        } else {
            if(auth()->check()){
                $notification = array(
                    'message' => 'Account Error, Please contact our aAdmins!',
                    'alert-type' => 'error',
                );
                Auth::guard('marketing')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/marketing/login')->with($notification);
            }
        }
    }

    public function invitationCodeCashoutInvoice(){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        }else if(auth()->user()->is_active == 1) {
            return view('marketing.marketing_invitation_code_invoice');
        } else {
            if(auth()->check()){
                $notification = array(
                    'message' => 'Account Error, Please contact our aAdmins!',
                    'alert-type' => 'error',
                );
                Auth::guard('marketing')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/marketing/login')->with($notification);
            }
        }
    }

    public function marketingTenantList(){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        }else if(auth()->user()->is_active == 1) {
            $tenant = Marketing::select(['id'])->where('id', auth()->user()->id)
                                ->with(['invitationCodeTenant' => function ($query) {
                                    $query->with(['invitationCode'])->select(['tenants.id as id_tenant', 'name', 'phone', 'id_inv_code', 'tenants.created_at as tanggal_bergabung']);
                                }
                            ])->get();
            return view('marketing.marketing_tenant_list', compact('tenant'));
        } else {
            if(auth()->check()){
                $notification = array(
                    'message' => 'Account Error, Please contact our aAdmins!',
                    'alert-type' => 'error',
                );
                Auth::guard('marketing')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/marketing/login')->with($notification);
            }
        }
    }

    public function marketingTenantDetail($inv_code, $id,){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        }else if(auth()->user()->is_active == 1) {
            $tenant = Tenant::select(['id', 'name', 'email', 'phone', 'is_active'])
                            ->with(['detail', 'storeDetail'])
                            ->where('id_inv_code', $inv_code)
                            ->where(DB::table('invitation_codes')
                                ->where('inv_code', $inv_code)
                                ->where('id_marketing', auth()->user()->id)
                                ->first()
                            )
                            ->find($id);
            return view('marketing.marketing_tenant_detail', compact('tenant'));
        } else {
            if(auth()->check()){
                $notification = array(
                    'message' => 'Account Error, Please contact our aAdmins!',
                    'alert-type' => 'error',
                );
                Auth::guard('marketing')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/marketing/login')->with($notification);
            }
        }
    }

    public function financeDashboard(){
        return view('marketing.marketing_finance');
    }

    public function historyPenarikan(){
        $withdrawData = Withdrawal::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->latest();
        $allData = $withdrawData->get();
        $penarikanTerbaru = $withdrawData->latest()->first();
        $allDataSum = $withdrawData->sum('nominal');

        return view('marketing.marketing_finance_penarikan', compact(['allData', 'penarikanTerbaru', 'allDataSum']));
    }

    public function invoiceTarikDana($id){
        $withdrawData = Withdrawal::select([ 'withdrawals.id',
                                             'withdrawals.email',
                                             'withdrawals.tanggal_penarikan',
                                             'withdrawals.nominal',
                                             'withdrawals.biaya_admin',
                                             'withdrawals.tanggal_masuk',
                                             'withdrawals.status' 
                                            ])
                                ->where('email', auth()->user()->email)
                                ->find($id);
        if(is_null($withdrawData) || empty($withdrawData)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'info',
            );
    
            return redirect()->route('marketing.finance.history_penarikan')->with($notification);
        }
        $rekening = Rekening::select(['swift_code', 'no_rekening'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        return view('marketing.marketing_penarikan_invoice', compact(['withdrawData', 'withdrawData', 'rekening']));
    }

    public function whatsappNotification(){
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);
        $nomor = "6285156719832";
        
        $body = "Hello, welcome to codelapan.com.";

        return $twilio->messages->create("whatsapp:$nomor",["from" => "whatsapp:$wa_from", "body" => $body]);
    }
}
