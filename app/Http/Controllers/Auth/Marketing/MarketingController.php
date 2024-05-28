<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Twilio\Rest\Client;
use Carbon\Carbon;
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
                                                }, 'invitationCode' => function($query) {
                                                    $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')->get();
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

    public function invitationCodeCashoutList($code){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diaktifkan!',
                'alert-type' => 'warning',
            );
            return view('marketing.auth.not_active')->with($notification);
        }else if(auth()->user()->is_active == 1) {
            $withdrawList = InvitationCode::where('inv_code', $code)
                                    ->with(['tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.id_inv_code',
                                            'tenants.name',
                                        ])
                                        ->with([
                                            'storeDetail' => function($query){
                                                $query->select([
                                                    'store_details.id',
                                                    'store_details.store_identifier',
                                                    'store_details.id_tenant',
                                                    'store_details.name as store_name'
                                                ]
                                                )->get();
                                            },
                                            'withdrawal' => function($query){
                                                $query->select([
                                                    'withdrawals.id',
                                                    'withdrawals.id_user',
                                                    'withdrawals.tanggal_penarikan',
                                                    'withdrawals.nominal'
                                                ])
                                                ->with([
                                                    'detailWithdraw' => function($query){
                                                        $query->select([
                                                            'detail_penarikans.id',
                                                            'detail_penarikans.id_penarikan',
                                                            'detail_penarikans.biaya_mitra'
                                                        ])->get();
                                                    }
                                                ])
                                                ->get();
                                            }
                                        ])
                                        ->get();
                                    }
                                    ])
                                    ->where('id_marketing', auth()->user()->id)
                                    ->first();
            $totalInsentif=0;
            foreach ($withdrawList->tenant as $tenantWD){
                foreach ($tenantWD->withdrawal as $wd){
                    $totalInsentif = $wd->detailWithdraw->sum('biaya_mitra');
                }
            }
            return view('marketing.marketing_invitation_code_data_penarikan', compact(['withdrawList', 'totalInsentif']));
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
                            ])
                            ->latest()
                            ->get();
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
            $tenant = Tenant::select(['tenants.id', 
                                        'tenants.name', 
                                        'tenants.email', 
                                        'tenants.phone', 
                                        'tenants.is_active',
                                        'tenants.id_inv_code'
                                    ])
                            ->with(['detail' => function($query){
                                $query->select([
                                    'detail_tenants.id',
                                    'detail_tenants.id_tenant',
                                    'detail_tenants.tempat_lahir',
                                    'detail_tenants.tanggal_lahir',
                                    'detail_tenants.jenis_kelamin',
                                    'detail_tenants.alamat',
                                ]);
                            }
                            ,'storeDetail' => function($query){
                                $query->select([
                                    'store_details.id',
                                    'store_details.id_tenant',
                                    'store_details.name as store_name',
                                    'store_details.alamat as store_alamat',
                                    'store_details.jenis_usaha',
                                    'store_details.photo as store_photo',
                                ]);
                            }, 'invitationCode' => function($query) {
                                $query->select([
                                    'invitation_codes.id',
                                    'invitation_codes.id_marketing',
                                    'invitation_codes.inv_code', 
                                    'invitation_codes.holder', 
                                ])->first();
                            }
                            , 'withdrawal' => function($query){
                                $query->select([
                                    'withdrawals.id',
                                    'withdrawals.id_user',
                                    'withdrawals.tanggal_penarikan', 
                                    'withdrawals.nominal', 
                                    'withdrawals.status'
                                ])
                                ->with(['detailWithdraw' => function($query){
                                    $query->select(['detail_penarikans.id', 
                                                    'detail_penarikans.id_penarikan',
                                                    'detail_penarikans.biaya_mitra',
                                                ])->get();
                                }])
                                ->withSum('detailWithdraw', 'biaya_mitra')
                                ->where('withdrawals.status', 1)
                                ->latest()
                                ->get();
                            }
                            ])
                            ->where('id_inv_code', $inv_code)
                            ->where(DB::table('invitation_codes')
                                ->where('inv_code', $inv_code)
                                ->where('id_marketing', auth()->user()->id)
                                ->first()
                            )
                            ->find($id);
            $totalPenghasilan = 0;
            foreach($tenant->withdrawal as $wd){
                $totalPenghasilan = $wd->detail_withdraw_sum_biaya_mitra;
            }
            return view('marketing.marketing_tenant_detail', compact('tenant', 'totalPenghasilan'));
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

    public function marketingPemasukanList(){
        $pemasukanTerbaru = Marketing::select(['marketings.id'])
                                        ->with(['invitationCodeTenant' => function($query){
                                            $query->select('tenants.id', 'tenants.name', 'tenants.id_inv_code')
                                                    ->with(['withdrawal' => function($query){
                                                        $query->select(['withdrawals.id', 'withdrawals.id_user', 'withdrawals.tanggal_penarikan', 'withdrawals.status'])
                                                                ->with(['detailWithdraw' => function($query){
                                                                    $query->select(['detail_penarikans.id', 
                                                                                    'detail_penarikans.id_penarikan',
                                                                                    'detail_penarikans.biaya_mitra',
                                                                                ])->get();
                                                                }])
                                                                ->where('withdrawals.status', 1)
                                                                ->latest()
                                                                // ->whereDate('tanggal_penarikan', Carbon::now())
                                                                ->get();
                                                    },
                                                    'invitationCode' => function($query) {
                                                        $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')
                                                                    ->groupBy(['invitation_codes.id',  'invitation_codes.inv_code', 'invitation_codes.holder'])
                                                                    ->get();
                                                    },
                                                    'storeDetail' => function($query) {
                                                        $query->select([
                                                            'store_details.id',
                                                            'store_details.store_identifier',
                                                            'store_details.id_tenant',
                                                            'store_details.name as store_name'
                                                        ])
                                                        ->groupBy(['store_details.id',  'store_details.store_identifier', 'store_details.id_tenant', 'store_details.name'])
                                                        ->get();
                                                    }
                                                    ])->get();
                                        }])
                                        ->find(auth()->user()->id);
        // dd($pemasukanTerbaru);
        $todayWithdraw = "";
        $monthWithdraw = "";
        $totalWithdrawMitra = "";
        foreach($pemasukanTerbaru->invitationCodeTenant as $inv){
            // dd($inv->invitationCode->inv_code);
            // dd($inv->withdrawal);
            foreach($inv->withdrawal as $withdrawal){
                $totalWithdrawMitra = $withdrawal->detailWithdraw->sum('biaya_mitra');
                //dd($withdrawal);
                //dd($inv->invitationCode->inv_code);
                //dd($inv->storeDetail->store_name);
            }
        }
        foreach($pemasukanTerbaru->invitationCodeTenant as $inv){
            foreach($inv->withdrawal as $withdrawal){
                $todayWithdraw = $withdrawal->select(['withdrawals.id', 'withdrawals.id_user'])
                                            ->whereDate('tanggal_penarikan', Carbon::now())
                                            ->where('withdrawals.status', 1)
                                            ->with(['detailWithdraw' => function($query){
                                                $query->select(['detail_penarikans.id', 
                                                                'detail_penarikans.id_penarikan',
                                                                'detail_penarikans.biaya_mitra',
                                                            ])->get();
                                            }])
                                            ->get();
                $monthWithdraw = $withdrawal->select(['withdrawals.id', 'withdrawals.id_user'])
                                            ->whereMonth('tanggal_penarikan', Carbon::now()->month)
                                            ->where('withdrawals.status', 1)
                                            ->with(['detailWithdraw' => function($query){
                                                $query->select(['detail_penarikans.id', 
                                                                'detail_penarikans.id_penarikan',
                                                                'detail_penarikans.biaya_mitra',
                                                            ])->get();
                                            }])
                                            ->get();
            }
        }
        $pemasukanMitraHariIni = "";
        $pemasukanMitraBulaniIni = "";
        foreach($todayWithdraw as $wd){
            $pemasukanMitraHariIni = $wd->detailWithdraw->sum('biaya_mitra');
        }
        foreach($monthWithdraw as $wd){
            $pemasukanMitraBulaniIni = $wd->detailWithdraw->sum('biaya_mitra');
        }
        return view('marketing.marketing_data_pemasukan', compact(['pemasukanTerbaru', 'pemasukanMitraHariIni', 'totalWithdrawMitra', 'pemasukanMitraBulaniIni']));
    }

    public function marketingPemasukanListToday(){
        $pemasukanTerbaru = Marketing::select(['marketings.id'])
                                        ->with(['invitationCodeTenant' => function($query){
                                            $query->select('tenants.id', 'tenants.name', 'tenants.id_inv_code')
                                                    ->with(['withdrawal' => function($query){
                                                        $query->select(['withdrawals.id', 'withdrawals.id_user', 'withdrawals.tanggal_penarikan', 'withdrawals.status'])
                                                                ->with(['detailWithdraw' => function($query){
                                                                    $query->select(['detail_penarikans.id', 
                                                                                    'detail_penarikans.id_penarikan',
                                                                                    'detail_penarikans.biaya_mitra',
                                                                                ])->get();
                                                                }])
                                                                ->where('withdrawals.status', 1)
                                                                ->whereDate('tanggal_penarikan', Carbon::now())
                                                                ->get();
                                                    },
                                                    'invitationCode' => function($query) {
                                                        $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')
                                                                    ->groupBy(['invitation_codes.id',  'invitation_codes.inv_code', 'invitation_codes.holder'])
                                                                    ->get();
                                                    },
                                                    'storeDetail' => function($query) {
                                                        $query->select([
                                                            'store_details.id',
                                                            'store_details.store_identifier',
                                                            'store_details.id_tenant',
                                                            'store_details.name as store_name'
                                                        ])
                                                        ->groupBy(['store_details.id',  'store_details.store_identifier', 'store_details.id_tenant', 'store_details.name'])
                                                        ->get();
                                                    }
                                                    ])->get();
                                        }])
                                        ->find(auth()->user()->id);
        return view('marketing.marketing_data_pemasukan_today', compact(['pemasukanTerbaru']));
    }

    public function marketingPemasukanListMonth(){
        $pemasukanTerbaru = Marketing::select(['marketings.id'])
                                        ->with(['invitationCodeTenant' => function($query){
                                            $query->select('tenants.id', 'tenants.name', 'tenants.id_inv_code')
                                                    ->with(['withdrawal' => function($query){
                                                        $query->select(['withdrawals.id', 'withdrawals.id_user', 'withdrawals.tanggal_penarikan', 'withdrawals.status'])
                                                                ->with(['detailWithdraw' => function($query){
                                                                    $query->select(['detail_penarikans.id', 
                                                                                    'detail_penarikans.id_penarikan',
                                                                                    'detail_penarikans.biaya_mitra',
                                                                                ])->get();
                                                                }])
                                                                ->where('withdrawals.status', 1)
                                                                ->whereMonth('tanggal_penarikan', Carbon::now()->month)
                                                                ->get();
                                                    },
                                                    'invitationCode' => function($query) {
                                                        $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')
                                                                    ->groupBy(['invitation_codes.id',  'invitation_codes.inv_code', 'invitation_codes.holder'])
                                                                    ->get();
                                                    },
                                                    'storeDetail' => function($query) {
                                                        $query->select([
                                                            'store_details.id',
                                                            'store_details.store_identifier',
                                                            'store_details.id_tenant',
                                                            'store_details.name as store_name'
                                                        ])
                                                        ->groupBy(['store_details.id',  'store_details.store_identifier', 'store_details.id_tenant', 'store_details.name'])
                                                        ->get();
                                                    }
                                                    ])->get();
                                        }])
                                        ->find(auth()->user()->id);
        return view('marketing.marketing_data_pemasukan_month', compact(['pemasukanTerbaru']));
    }

    public function marketingMerchant(){
        $pemasukanMerchant = Marketing::select(['marketings.id'])
                                        ->with(['invitationCodeTenant' => function($query){
                                            $query->select('tenants.id', 'tenants.name', 'tenants.id_inv_code', 'tenants.created_at', 'tenants.phone')
                                                    ->with(['invitationCode' => function($query) {
                                                        $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')
                                                                    ->groupBy(['invitation_codes.id',  'invitation_codes.inv_code', 'invitation_codes.holder'])
                                                                    ->get();
                                                    },
                                                    'storeDetail' => function($query) {
                                                        $query->select([
                                                            'store_details.id',
                                                            'store_details.store_identifier',
                                                            'store_details.id_tenant',
                                                            'store_details.name as store_name'
                                                        ])
                                                        ->groupBy(['store_details.id',  'store_details.store_identifier', 'store_details.id_tenant', 'store_details.name'])
                                                        ->get();
                                                    }
                                                    ])
                                                    ->withSum('withdrawalDetail', 'biaya_mitra')
                                                    ->get();
                                        }])
                                        ->find(auth()->user()->id);
        //dd($pemasukanMerchant->toArray());
        foreach($pemasukanMerchant->invitationCodeTenant as $inv){
            //dd($inv->storeDetail);
            // dd($inv->withdrawal);
            // foreach($inv->withdrawal as $withdrawal){
            //     $totalWithdrawMitra = $withdrawal->detailWithdraw->sum('biaya_mitra');
            //     //dd($withdrawal);
            //     //dd($inv->invitationCode->inv_code);
            //     //dd($inv->storeDetail->store_name);
            // }
        }

        return view('marketing.marketing_merchant_list', compact('pemasukanMerchant'));
    }

    public function financeDashboard(){
        return view('marketing.marketing_finance');
    }

    public function financeSaldo(){
        $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        return view('marketing.marketing_finance_saldo', compact('qrisWallet'));
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
