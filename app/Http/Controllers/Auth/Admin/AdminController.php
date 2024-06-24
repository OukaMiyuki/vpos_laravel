<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
// use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Response;
use Stevebauman\Location\Facades\Location;
use GuzzleHttp\Client as GuzzleHttpClient;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Withdrawal;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\Invoice;
use App\Models\UmiRequest;
use App\Models\TenantQrisAccount;
use App\Models\DetailPenarikan;
use App\Models\StoreDetail;
use App\Models\StoreList;
use App\Models\InvitationCode;
use App\Models\AgregateWallet;
use App\Models\QrisWallet;
use App\Models\HistoryCashbackAdmin;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\BiayaAdminTransferDana;
use App\Models\Rekening;
use App\Models\History;
use App\Models\SettlementDateSetting;
use App\Models\SettlementHstory;
use App\Models\Settlement;
use App\Models\HistoryCashbackPending;
use App\Models\SettlementPending;
use Exception;

class AdminController extends Controller {

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

    private function createHistoryUser($action, $log, $status){
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $ip, $log, $status);
        }
    }

    private function sendNotificationToUser($body, $phone){
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $postResponse = "";
        $noHP = $phone;
        if(!preg_match("/[^+0-9]/",trim($noHP))){
            if(substr(trim($noHP), 0, 2)=="62"){
                $hp    =trim($noHP);
            }
            else if(substr(trim($noHP), 0, 1)=="0"){
                $hp    ="62".substr(trim($noHP), 1);
            }
        }

        $url = 'https://waq.my.id/send-message';
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $data = [
            'api_key' => $api_key,
            'sender' => $sender,
            'number' => $hp,
            'message' => $body
        ];
        try {
            $postResponse = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
            ]);
        } catch(Exception $ex){
            $action = "Admin Send User Notification Fail";
            $this->createHistoryUser($action, $ex, 0);
        }
        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "Admin Send User Notification Fail to ".$phone;
            $this->createHistoryUser($action, "Whatsapp Response NULL to destination ".$phone, 0);
        } else {
            $responseCode = $postResponse->getStatusCode();
            if($responseCode != 200){
                $action = "Send Whatsapp Notification Fail to destination ".$phone;
                $this->createHistoryUser($action, $ex, 0);
            }
        }
    }

    public function index(){
        $marketingCount = Marketing::count();
        $mitraBisnis = Tenant::where('id_inv_code', '==', 0)->count();
        $mitraTenant = Tenant::where('id_inv_code', '!=', 0)->count();
        $withdrawals = Withdrawal::where('email', '!=' , auth()->user()->email);
        $withDrawToday = Withdrawal::select([
                                        'withdrawals.id',
                                        'withdrawals.invoice_pemarikan',
                                        'withdrawals.id_user',
                                        'withdrawals.id_rekening',
                                        'withdrawals.email',
                                        'withdrawals.jenis_penarikan',
                                        'withdrawals.tanggal_penarikan',
                                        'withdrawals.nominal',
                                        'withdrawals.biaya_admin',
                                        'withdrawals.tanggal_masuk',
                                        'withdrawals.status',
                                    ])
                                    ->where('email', '!=' , auth()->user()->email)
                                     ->whereDate('tanggal_penarikan', Carbon::now())
                                     ->where('status', 1)
                                     ->with([
                                        'detailWithdraw' => function($query){
                                            $query->select([
                                                        'detail_penarikans.id',
                                                        'detail_penarikans.id_insentif',
                                                        'detail_penarikans.id_penarikan',
                                                        'detail_penarikans.nominal'
                                                    ])
                                                    ->where('id_insentif', 3);
                                        }
                                      ])
                                     ->get();

        $marketing = Marketing::select([
                                        'marketings.id',
                                        'marketings.name',
                                        'marketings.email',
                                        'marketings.is_active',
                                        'marketings.created_at'
                                    ])
                                    ->with(['detail' => function($query){
                                        $query->select(['detail_marketings.id', 'detail_marketings.id_marketing', 'detail_marketings.jenis_kelamin']);
                                    }])
                                    ->latest()
                                    ->take(5)
                                    ->get();
        $totalWithdrawToday = 0;
        foreach($withDrawToday as $wd){
            $totalWithdrawToday+=$wd->detailWithdraw->sum('nominal');
        }

        $withdrawCount = $withdrawals->count();
        $withdrawNew = $withdrawals->select([
                                'withdrawals.id',
                                'withdrawals.invoice_pemarikan',
                                'withdrawals.tanggal_penarikan',
                                'withdrawals.nominal',
                                'withdrawals.status',
                                'withdrawals.created_at',
                            ])
                            ->with(['detailWithdraw' => function($query){
                                $query->select([
                                    'detail_penarikans.id',
                                    'detail_penarikans.id_insentif',
                                    'detail_penarikans.id_penarikan',
                                    'detail_penarikans.nominal'
                                ])
                                ->where('id_insentif', 3);
                            }])
                            ->take(5)
                            ->latest()
                            ->get();

        return view('admin.dashboard', compact(['marketingCount', 'mitraBisnis', 'mitraTenant', 'withdrawCount', 'totalWithdrawToday', 'marketing', 'withdrawNew']));
    }

    public function adminMenuDashboard(){
        return view('admin.admin_menu_dashboard');
    }

    public function adminMenuUserTransaction(Request $request){
        if ($request->ajax()) {
            $data = Invoice::select([
                                        'invoices.id',
                                        'invoices.store_identifier',
                                        'invoices.email',
                                        'invoices.id_tenant',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.nominal_bayar',
                                        'invoices.kembalian',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                        'invoices.created_at',
                                        'invoices.updated_at'
                                    ])
                                    ->latest()
                                    ->get();
            
            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('nomor_invoice', function($data) {
                                    return $data->nomor_invoice;
                                })
                                ->editColumn('store_identifier', function($data) {
                                    return $data->store_identifier;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status_pembayaran == 1)?'<span class="badge bg-soft-success text-success">Selesai</span>':'<span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>');
                                })
                                ->rawColumns(['status'])
                                ->editColumn('tanggal_transaksi', function($data) {
                                    $date = \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->created_at)->format('H:i:s');
                                    $dateTimeTransaksi = $date." ".$time;
                                    return $dateTimeTransaksi;
                                })
                                ->editColumn('tanggal_pembayaran', function($data) {
                                    $date = \Carbon\Carbon::parse($data->tanggal_pelunasan)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->updated_at)->format('H:i:s');
                                    $dateTimePembayaran = $date." ".$time;
                                    return $dateTimePembayaran;
                                })
                                ->editColumn('jenis_pembayaran', function($data) {
                                    return $data->jenis_pembayaran;
                                })
                                ->editColumn('nominal_bayar', function($data) {
                                    return $data->nominal_bayar;
                                })
                                ->editColumn('mdr', function($data) {
                                    return $data->mdr;
                                })
                                ->editColumn('nominal_mdr', function($data) {
                                    return $data->nominal_mdr;
                                })
                                ->editColumn('nominal_terima_bersih', function($data) {
                                    return $data->nominal_terima_bersih;
                                })
                                ->make(true);
        }
        return view('admin.admin_menu_dashboard_user_transaction');
        // $invoice = Invoice::latest()->get();
        // return view('admin.admin_menu_dashboard_user_transaction', compact('invoice'));
    }

    public function adminMenuUserTransactionSettlementReady(){
        $invoice = Invoice::where('settlement_status', 0)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 1)
                                    ->whereDate('tanggal_transaksi', '!=', Carbon::now())
                                    ->latest()
                                    ->get();
        return view('admin.admin_menu_dashboard_user_transaction_settlement', compact('invoice'));
    }

    public function adminMenuUserWithdrawals(){
        $withdrawals = Withdrawal::select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.email',
                                    'withdrawals.jenis_penarikan',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                    'withdrawals.created_at',
                                    'withdrawals.updated_at',
                                ])
                                ->where('email', '!=', 'adminsu@visipos.id')
                                ->latest()
                                ->get();

        return view('admin.admin_menu_dashboard_user_withdrawals', compact(['withdrawals']));
    }

    public function adminMenuUserWithdrawalDetail($id){
        $withdraw = Withdrawal::select([
                                'withdrawals.id',
                                'withdrawals.invoice_pemarikan',
                                'withdrawals.email',
                                'withdrawals.tanggal_penarikan',
                                'withdrawals.nominal',
                                'withdrawals.biaya_admin',
                                'withdrawals.status',
                                'withdrawals.created_at',
                            ])
                            ->with([
                                'detailWithdraw' => function($query){
                                    $query->select([
                                        'detail_penarikans.id',
                                        'detail_penarikans.id_insentif',
                                        'detail_penarikans.id_penarikan',
                                        'detail_penarikans.nominal'
                                    ])
                                    ->with([
                                        'insentif' => function($query){
                                            $query->select([
                                                'biaya_admin_transfer_danas.id',
                                                'biaya_admin_transfer_danas.jenis_insentif',
                                            ]);
                                        }
                                    ]);
                                }
                            ])
                            ->where('email', '!=', 'adminsu@visipos.id')
                            ->find($id);
        if(is_null($withdraw) || empty($withdraw) || $withdraw == NULL){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.menu.userWithdrawals')->with($notification);
        }
        $rekening = Rekening::where('email', $withdraw->email)->first();
        $user = "";
        $userType = "";
        $user = Marketing::select(['marketings.id', 'marketings.email', 'marketings.name', 'marketings.phone', 'marketings.is_active'])->where('email', $withdraw->email)->first();
        $userType = "Mitra Aplikasi";
        if(is_null($user) || empty($user)){
            $user = Tenant::select(['tenants.id', 'tenants.email', 'tenants.phone', 'tenants.name', 'tenants.is_active', 'tenants.id_inv_code'])->where('email', $withdraw->email)->first();
            if($user->id_inv_code == 0){
                $userType = "Mitra Bisnis";
            } else {
                $userType = "Mitra Tenant";
            }
        }

        return view('admin.admin_user_withdraw_invoice', compact(['withdraw', 'user', 'userType', 'rekening']));
    }

    public function adminMenuUserUmiRequest(){
        $umiRequest = UmiRequest::select([
                                    'umi_requests.id',
                                    'umi_requests.id_tenant',
                                    'umi_requests.email',
                                    'umi_requests.store_identifier',
                                    'umi_requests.tanggal_pengajuan',
                                    'umi_requests.tanggal_approval',
                                    'umi_requests.is_active',
                                    'umi_requests.file_path',
                                    'umi_requests.note',
                                    'umi_requests.created_at',
                                    'umi_requests.updated_at'
                                ])
                                ->latest()
                                ->get();
        return view('admin.admin_menu_dashboard_user_umi_request', compact(['umiRequest']));
    }

    public function adminMenuUserUmiRequestDownload($id){
        $umiXLS = UmiRequest::find($id);
        $userDocsPath = Storage::path('public/docs/umi/user_doc');
        $file_path = $userDocsPath. "/" . $umiXLS->file_path;
        $headers = array(
            'Content-Type: xlsx',
            'Content-Disposition: attachment; filename='.$umiXLS->file_path,
        );

        if ( file_exists( $file_path ) ) {
            return Response::download( $file_path, $umiXLS->file_path, $headers );
        } else {
            exit( 'Requested file does not exist on our server!' );
        }
    }

    public function adminMenuUserUmiRequestApprove(Request $request){
        $action="";
        $umiRequest = UmiRequest::where('store_identifier', $request->store_identifier)->find($request->id);
        DB::connection()->enableQueryLog();
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Approve UMI";
        } else {
            $action = "Administrator : Approve UMI";
        }
        if(is_null($umiRequest) || empty($umiRequest)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $umiRequest->update([
            'tanggal_approval' => Carbon::now(),
            'is_active' => 1,
            'note' => $request->note
        ]);
        $store = "";
        $store = StoreDetail::where('store_identifier', $request->store_identifier)->first();
        if(is_null($store) || empty($store) || $store == ""){
            $store = StoreList::where('store_identifier', $request->store_identifier)->first();
        }

        $store->update([
            'status_umi' => 1
        ]);
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Umi berhasil disetujui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserUmiRequestReject(Request $request){
        DB::connection()->enableQueryLog();
        $action="";
        $umiRequest = UmiRequest::where('store_identifier', $request->store_identifier)->find($request->id);
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Reject UMI";
        } else {
            $action = "Administrator : Reject UMI";
        }
        if(is_null($umiRequest) || empty($umiRequest)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }

        $umiRequest->update([
            'tanggal_approval' => NULL,
            'is_active' => 2,
            'note' => $request->note
        ]);
        $store = "";
        $store = StoreDetail::where('store_identifier', $request->store_identifier)->first();

        if(is_null($store) || empty($store) || $store == ""){
            $store = StoreList::where('store_identifier', $request->store_identifier)->first();
        }

        $store->update([
            'status_umi' => 2
        ]);
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Umi berhasil ditolak!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserTenantQris(){
        $tenantQris = TenantQrisAccount::latest()->get();
        return view('admin.admin_menu_dashboard_user_tenant_qris', compact(['tenantQris']));
    }

    public function adminMenuUserTenantQrisRegister(Request $request){
        DB::connection()->enableQueryLog();
        $action = "";
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Qris ACcount Register | ".$request->store_identifier;
        } else {
            $action = "Administrator : Qris ACcount Register | ".$request->store_identifier;
        }
        $store_identifier = $request->store_identifier;
        $qris_login = $request->qris_login;
        $qris_password = $request->qris_password;
        $qris_merchant_id = $request->qris_merchant_id;
        $qris_store_id = $request->qris_store_id;
        $mdr = $request->mdr;
        $store = "";
        $store = StoreDetail::where('store_identifier', $store_identifier)->first();
        if(is_null($store) || empty($store) || $store == ""){
            $store = StoreList::where('store_identifier', $store_identifier)->first();
            TenantQrisAccount::create([
                'store_identifier' => $store_identifier,
                'id_tenant' => $store->id_user,
                'email' => $store->email,
                'qris_login_user' => $qris_login,
                'qris_password' => $qris_password,
                'qris_merchant_id' => $qris_merchant_id,
                'qris_store_id' => $qris_store_id,
                'mdr' => $mdr
            ]);
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Akun Tenant Qris berhasil dibuat!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
        TenantQrisAccount::create([
            'store_identifier' => $store_identifier,
            'id_tenant' => $store->id_tenant,
            'email' => $store->email,
            'qris_login_user' => $qris_login,
            'qris_password' => $qris_password,
            'qris_merchant_id' => $qris_merchant_id,
            'qris_store_id' => $qris_store_id,
            'mdr' => $mdr
        ]);
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Akun Tenant Qris berhasil dibuat!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserTenantQrisUpdate(Request $request){
        DB::connection()->enableQueryLog();
        $action = "";
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Update Qris Account | ".$request->store_identifier;
        } else {
            $action = "Administrator : Update Qris Account | ".$request->store_identifier;
        }
        $id = $request->id;
        $store_identifier = $request->store_identifier;
        $qris_login = $request->qris_login;
        $qris_password = $request->qris_password;
        $qris_merchant_id = $request->qris_merchant_id;
        $qris_store_id = $request->qris_store_id;
        $mdr = $request->mdr;
        $qris = TenantQrisAccount::where('store_identifier', $store_identifier)->find($id);
        if(is_null($qris) || empty($qris)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $qris->update([
            'qris_login_user' => $qris_login,
            'qris_password' => $qris_password,
            'qris_merchant_id' => $qris_merchant_id,
            'qris_store_id' => $qris_store_id,
            'mdr' => $mdr
        ]);
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Akun Tenant Qris berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserTenantQrisDelete($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $qris = TenantQrisAccount::find($id);
        if(is_null($qris) || empty($qris)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Delete Qris Account";
        } else {
            $action = "Administrator : Delete Qris Account";
        }
        $qris->delete();
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data akun qris berhasil dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminList(){
        $adminList = Admin::select([
                                'admins.id',
                                'admins.name',
                                'admins.email',
                                'admins.phone',
                                'admins.is_active',
                            ])
                            ->with(['detail' => function($query){
                                $query->select([
                                    'detail_admins.id',
                                    'detail_admins.id_admin',
                                    'detail_admins.jenis_kelamin',
                                    'detail_admins.no_ktp',
                                ]);
                            }])
                            ->where('access_level', 1)
                            ->latest()
                            ->get();
            return view('admin.admin_administrator_list', compact('adminList'));
    }

    public function adminCreate(){
        return view('admin.admin_administrator_create');
    }

    public function adminRegister(Request $request){
        DB::connection()->enableQueryLog();
        $action = "Admin Super User : Register new Administrator";
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

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if(!is_null($admin)) {
            $admin->detailAdminStore($admin);
        }

        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

        $notification = array(
            'message' => 'Admin berhasil diregister!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.administrator.list')->with($notification);
    }

    public function adminActivation($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $admin = Admin::find($id);

        if(is_null($admin) || empty($admin)){
            $notification = array(
                'message' => 'Data Admin tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.administrator.list')->with($notification);
        }

        if($admin->is_active == 0){
            $action = "Admin Super User : Activate Administrator";
            $admin->update([
                'is_active' => 1
            ]);
        } else {
            $action = "Admin Super User : Deactivate Administrator";
            $admin->update([
                'is_active' => 0
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Admin berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.administrator.list')->with($notification);
    }

    public function adminDetail($id){
        $admin = Admin::select([
                        'admins.id',
                        'admins.name',
                        'admins.email',
                        'admins.phone',
                        'admins.is_active'
                    ])
                    ->with(['detail' => function($query){
                        $query->select([
                            'detail_admins.id',
                            'detail_admins.id_admin',
                            'detail_admins.no_ktp',
                            'detail_admins.tempat_lahir',
                            'detail_admins.tanggal_lahir',
                            'detail_admins.jenis_kelamin',
                            'detail_admins.alamat',
                            'detail_admins.photo'
                        ]);
                    }])
                    ->find($id);

        if(is_null($admin) || empty($admin)){
            $notification = array(
                'message' => 'Data Admin tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.administrator.list')->with($notification);
        }

        return view('admin.admin_administrator_detail', compact(['admin']));
    }

    public function adminDashboardSaldo(){
        $adminQrisWallet = QrisWallet::select(['saldo'])->where('email', auth()->user()->email)->find(auth()->user()->id);
        $agregateWalletforMaintenance = AgregateWallet::where('wallet_type', 'maintenance')->select(['saldo'])->first();
        $agregateWalletforTransfer = AgregateWallet::where('wallet_type', 'transfer')->select(['saldo'])->first();
        $totalAgregate = $agregateWalletforMaintenance->saldo+$agregateWalletforTransfer->saldo;
        $historyCashbackAdmin = HistoryCashbackAdmin::sum('nominal_terima_mdr');
        $historyCashbackAdminSettlement = HistoryCashbackPending::sum('nominal_terima_mdr');
        $nobuWithdrawFeeHistory = NobuWithdrawFeeHistory::sum('nominal');
        $withdrawals = Withdrawal::select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.email',
                                    'withdrawals.jenis_penarikan',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                    'withdrawals.created_at',
                                    'withdrawals.updated_at',
                                ])
                                ->where('email', '!=', 'adminsu@visipos.id')
                                ->latest()
                                ->take(10)
                                ->get();
        return view('admin.admin_menu_dashboard_saldo', compact(['adminQrisWallet', 'totalAgregate', 'agregateWalletforMaintenance', 'agregateWalletforTransfer', 'historyCashbackAdmin', 'nobuWithdrawFeeHistory', 'withdrawals', 'historyCashbackAdminSettlement']));
    }

    public function adminDashboardSaldoQris(){
        $withdrawalTenant = Withdrawal::select([
                                            'withdrawals.id',
                                        ])
                                        ->with([
                                            'detailWithdraw' => function($query){
                                                $query->select([
                                                    'detail_penarikans.id',
                                                    'detail_penarikans.id_penarikan',
                                                    'detail_penarikans.nominal',
                                                ])
                                                ->where('id_insentif', 3);
                                            }
                                        ])
                                        ->where('email', '!=', auth()->user()->email)
                                        ->where('jenis_penarikan', 'Penarikan Dana Tenant')
                                        ->where('status', 1)
                                        ->latest()
                                        ->get();
        $withdrawalMitraMarketingBisnis = Withdrawal::select([
                                                            'withdrawals.id',
                                                        ])
                                                        ->with([
                                                            'detailWithdraw' => function($query){
                                                                $query->select([
                                                                    'detail_penarikans.id',
                                                                    'detail_penarikans.id_penarikan',
                                                                    'detail_penarikans.nominal',
                                                                ])
                                                                ->where(
                                                                    function($query){
                                                                        $query->where('id_insentif', 3)
                                                                                ->orWhere('id_insentif', 5);
                                                                    }
                                                                );
                                                            }
                                                        ])
                                                        ->where('email', '!=', auth()->user()->email)
                                                        ->where(
                                                            function($query){
                                                                $query->where('jenis_penarikan', 'Penarikan Dana Mitra Aplikasi')
                                                                        ->orWhere('jenis_penarikan', 'Penarikan Dana Mitra Bisnis');
                                                            }
                                                        )
                                                        ->where('status', 1)
                                                        ->latest()
                                                        ->get();
        $withdrawals = Withdrawal::select([
                                        'withdrawals.id',
                                        'withdrawals.invoice_pemarikan',
                                        'withdrawals.email',
                                        'withdrawals.jenis_penarikan',
                                        'withdrawals.tanggal_penarikan',
                                        'withdrawals.nominal',
                                        'withdrawals.biaya_admin',
                                        'withdrawals.status',
                                        'withdrawals.created_at',
                                        'withdrawals.updated_at',
                                    ])
                                    ->where('email', '!=', 'adminsu@visipos.id')
                                    ->latest()
                                    ->get();
        $insentifFromTenant = 0;
        foreach($withdrawalTenant as $wdTenant){
            $insentifFromTenant = $wdTenant->detailWithdraw->sum('nominal');
        }
        $insentifFromMitra = 0;
        foreach($withdrawalMitraMarketingBisnis as $wdMitra){
            foreach($wdMitra->detailWithdraw as $wddt){
                $insentifFromMitra+=$wddt->nominal;
            }
        }
        $totalPendapatanAdmin = $insentifFromTenant+$insentifFromMitra;
        $adminQrisWallet = QrisWallet::select(['saldo'])->where('email', auth()->user()->email)->find(auth()->user()->id);
        return view('admin.admin_menu_dashboard_saldo_qris', compact(['withdrawals', 'totalPendapatanAdmin', 'adminQrisWallet']));
    }

    public function adminDashboardSaldoAgregate(){
        $withdrawals = Withdrawal::select([
                                        'withdrawals.id',
                                        'withdrawals.invoice_pemarikan',
                                        'withdrawals.tanggal_penarikan',
                                        'withdrawals.jenis_penarikan',
                                        'withdrawals.status',
                                        'withdrawals.created_at',
                                    ])
                                    ->with([
                                        'detailWithdraw' => function($query){
                                            $query->select([
                                                'detail_penarikans.id',
                                                'detail_penarikans.id_penarikan',
                                                'detail_penarikans.nominal',
                                            ])
                                            ->where(
                                                function($query){
                                                    $query->where('id_insentif', 2)
                                                            ->orWhere('id_insentif', 4);
                                                }
                                            );
                                        }
                                    ])
                                    ->where('email', '!=', auth()->user()->email)
                                    ->where('status', 1)
                                    ->latest()
                                    ->get();
            $agregate = 0;
            foreach($withdrawals as $wdagg){
                foreach($wdagg->detailWithdraw as $wd){
                    $agregate+=$wd->nominal;
                }
            }
            $agregateSaldo = AgregateWallet::sum('saldo');
            return view('admin.admin_menu_dashboard_saldo_agregate', compact(['withdrawals', 'agregate', 'agregateSaldo']));
    }

    public function adminDashboardSaldoAgregateAplikasi(){
        $withdrawals = Withdrawal::select([
                                            'withdrawals.id',
                                            'withdrawals.invoice_pemarikan',
                                            'withdrawals.tanggal_penarikan',
                                            'withdrawals.jenis_penarikan',
                                            'withdrawals.status',
                                            'withdrawals.created_at',
                                        ])
                                        ->with([
                                            'detailWithdraw' => function($query){
                                                $query->select([
                                                    'detail_penarikans.id',
                                                    'detail_penarikans.id_penarikan',
                                                    'detail_penarikans.nominal',
                                                ])
                                                ->where('id_insentif', 4);
                                            }
                                        ])
                                        ->where('email', '!=', auth()->user()->email)
                                        ->where('status', 1)
                                        ->latest()
                                        ->get();
        $agregateSaldoAplikasi = AgregateWallet::select('saldo')->find(1);

        return view('admin.admin_menu_dashboard_saldo_agregate_aplikasi', compact(['withdrawals', 'agregateSaldoAplikasi']));
    }

    public function adminDashboardSaldoAgregateTransfer(){
        $withdrawals = Withdrawal::select([
                                            'withdrawals.id',
                                            'withdrawals.invoice_pemarikan',
                                            'withdrawals.tanggal_penarikan',
                                            'withdrawals.jenis_penarikan',
                                            'withdrawals.status',
                                            'withdrawals.created_at',
                                        ])
                                        ->with([
                                            'detailWithdraw' => function($query){
                                                $query->select([
                                                    'detail_penarikans.id',
                                                    'detail_penarikans.id_penarikan',
                                                    'detail_penarikans.nominal',
                                                ])
                                                ->where('id_insentif', 2);
                                            }
                                        ])
                                        ->where('email', '!=', auth()->user()->email)
                                        ->where('status', 1)
                                        ->latest()
                                        ->get();
        $agregateSaldoAplikasi = AgregateWallet::select('saldo')->find(2);

        return view('admin.admin_menu_dashboard_saldo_agregate_transfer', compact(['withdrawals', 'agregateSaldoAplikasi']));
    }

    public function adminDashboardSaldoCashback(){
        $historyCashback = HistoryCashbackAdmin::select([
                                                    'history_cashback_admins.id',
                                                    'history_cashback_admins.id_invoice',
                                                    'history_cashback_admins.nominal_terima_mdr',
                                                    'history_cashback_admins.created_at'
                                                ])
                                                ->with([
                                                    'invoice' => function($query){
                                                        $query->select([
                                                            'invoices.id',
                                                            'invoices.nomor_invoice',
                                                            'invoices.tanggal_transaksi',
                                                            'invoices.jenis_pembayaran',
                                                            'invoices.nominal_bayar',
                                                            'invoices.mdr',
                                                            'invoices.nominal_mdr',
                                                            'invoices.nominal_terima_bersih',
                                                            'invoices.created_at',
                                                        ]);
                                                    }
                                                ])
                                                ->latest()
                                                ->get();
        $totakCashback = $historyCashback->sum('nominal_terima_mdr');
        return view('admin.admin_menu_dashboard_saldo_history_cashback', compact(['historyCashback', 'totakCashback']));
    }

    public function adminDashboardSaldoCashbackPending(){
        $historyCashback = HistoryCashbackPending::select([
                                                        'history_cashback_pendings.id',
                                                        'history_cashback_pendings.id_invoice',
                                                        'history_cashback_pendings.nominal_terima_mdr',
                                                        'history_cashback_pendings.settlement_status',
                                                        'history_cashback_pendings.created_at'
                                                    ])
                                                    ->with([
                                                        'invoice' => function($query){
                                                            $query->select([
                                                                'invoices.id',
                                                                'invoices.nomor_invoice',
                                                                'invoices.tanggal_transaksi',
                                                                'invoices.jenis_pembayaran',
                                                                'invoices.nominal_bayar',
                                                                'invoices.mdr',
                                                                'invoices.nominal_mdr',
                                                                'invoices.nominal_terima_bersih',
                                                                'invoices.created_at',
                                                            ]);
                                                        }
                                                    ])
                                                    ->where('settlement_status', 0)
                                                    ->latest()
                                                    ->get();
        $totakCashback = $historyCashback->sum('nominal_terima_mdr');
        return view('admin.admin_menu_dashboard_saldo_history_cashback_settlement_pending', compact(['historyCashback', 'totakCashback']));
    }

    public function adminDashboardNobuFeeTransfer(){
        $nobuFeeHistory = NobuWithdrawFeeHistory::select([
                                                'nobu_withdraw_fee_histories.id',
                                                'nobu_withdraw_fee_histories.id_penarikan',
                                                'nobu_withdraw_fee_histories.nominal',
                                            ])
                                            ->with([
                                                'withdraw' => function($query){
                                                    $query->select([
                                                        'withdrawals.id',
                                                        'withdrawals.invoice_pemarikan',
                                                        'withdrawals.jenis_penarikan',
                                                        'withdrawals.tanggal_penarikan',
                                                        'withdrawals.nominal',
                                                        'withdrawals.biaya_admin',
                                                    ]);
                                                }
                                            ])
                                            ->latest()
                                            ->get();

        return view('admin.admin_menu_dashboard_saldo_history_nobu_fee_transfer', compact(['nobuFeeHistory']));
    }

    public function adminDashboardMarketing(){
        $marketingList = Marketing::count();
        $marketingData = Marketing::with('detail')->where('is_active', 1)->latest()->take(5)->get();
        $marketingAktivasi = Marketing::where('is_active', 0)->latest()->take(10)->get();
        $invitationcodeCount = InvitationCode::select([
                                                'invitation_codes.id',
                                                'invitation_codes.inv_code'
                                            ])
                                            ->with(['tenant' => function($query){
                                                    $query->select([
                                                        'tenants.id',
                                                        'tenants.id_inv_code'
                                                    ]);
                                            }])
                                            ->latest()
                                            ->get();
        $invitationCodeCount = $invitationcodeCount->count();
        $invTenantCount = 0;
        foreach($invitationcodeCount as $inv){
            $invTenantCount+=$inv->tenant->count();
        }

        return view('admin.admin_marketing_dashboard', compact('marketingList', 'marketingData', 'marketingAktivasi', 'invitationCodeCount', 'invTenantCount'));
    }

    public function adminMarketingAccountActivation($id){
        $marketing = Marketing::find($id);
        DB::connection()->enableQueryLog();
        $action = "";
        if(is_null($marketing) || empty($marketing)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.marketing.list')->with($notification);
        }
        $phone = $marketing->phone;
        if($marketing->is_active == 0){
            if(is_null($marketing->phone_number_verified_at) || empty($marketing->phone_number_verified_at) || $marketing->phone_number_verified_at == NULL || $marketing->phone_number_verified_at == ""){
                $notification = array(
                    'message' => 'Akun gagal diaktifkan, user bersangkutan belum melakukan verifikasi nomor Whatsapp!',
                    'alert-type' => 'warning',
                );
                return redirect()->route('admin.dashboard.marketing.list')->with($notification);
            }
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Mitra Aplikasi | ".$marketing->name;
            } else {
                $action = "Administrator : Activating Mitra Aplikasi | ".$marketing->name;
            }
            $body = "Terima kasih telah mendaftar sebagai Mitra Aplikasi pada aplikasi Visioner, akun anda telah sukses diaktifkan oleh admin";
            $this->sendNotificationToUser($body, $phone);
            $marketing->is_active = 1;
        } else if($marketing->is_active == 1){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Mitra Aplikasi | ".$marketing->name;
            } else {
                $action = "Administrator : Deactivating Mitra Aplikasi | ".$marketing->name;
            }
            $marketing->is_active = 2;
            $body = "Karena aktivitas yang mencurigakan, admin memutuskan untuk menonaktifkan akun mitra aplikasi anda, Jika anda merasa tidak melakukan aktivitas yang ilegal, segera hubungi Admin untuk proses lebih lanjut!";
            $this->sendNotificationToUser($body, $phone);
        } else if($marketing->is_active == 2){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Reactivating Mitra Aplikasi | ".$marketing->name;
            } else {
                $action = "Administrator : Reactivating Mitra Aplikasi | ".$marketing->name;
            }
            $marketing->is_active = 1;
            $body = "Akun anda telah sukses di re-aktivasi oleh admin, anda dapat melakukan aktivitas login kembali melalui login form pada website Visipos.";
            $this->sendNotificationToUser($body, $phone);
        }

        if($marketing->is_active == 2) {
            $invCode = InvitationCode::where('id_marketing', $marketing->id)->latest()->get();
            if(!is_null($invCode) || !empty($invCode)){
                foreach($invCode as $inv){
                    $inv->update([
                        'is_active' => 0
                    ]);
                }
            }
        } else if($marketing->is_active == 1){
            $invCode = InvitationCode::where('id_marketing', $marketing->id)->latest()->get();
            if(!is_null($invCode) || !empty($invCode)){
                foreach($invCode as $inv){
                    $inv->update([
                        'is_active' => 1
                    ]);
                }
            }
        }

        $marketing->save();
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMarketingProfile($id){
        $marketing = Marketing::select([
                                    'marketings.id',
                                    'marketings.name',
                                    'marketings.email',
                                    'marketings.email_verified_at',
                                    'marketings.phone',
                                    'marketings.phone_number_verified_at',
                                    'marketings.is_active',
                                    'marketings.created_at',
                                ])
                                ->with(['detail' => function($query){
                                    $query->select([
                                        'detail_marketings.id',
                                        'detail_marketings.id_marketing',
                                        'detail_marketings.no_ktp',
                                        'detail_marketings.tempat_lahir',
                                        'detail_marketings.tanggal_lahir',
                                        'detail_marketings.jenis_kelamin',
                                        'detail_marketings.alamat',
                                        'detail_marketings.photo',
                                    ]);
                                },
                                'invitationCode' => function($query){
                                    $query->select([
                                        'invitation_codes.id',
                                        'invitation_codes.id_marketing',
                                        'invitation_codes.inv_code',
                                        'invitation_codes.holder',
                                        'invitation_codes.is_active',
                                        'invitation_codes.created_at',
                                    ])
                                    ->with(['tenant' => function($query){
                                        $query->select([
                                                    'tenants.id',
                                                    'tenants.id_inv_code'
                                        ]);
                                    }]);
                                }
                                ])
                                ->find($id);

        if(is_null($marketing) || empty($marketing)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.marketing.list')->with($notification);
        }

        return view('admin.admin_marketing_profile', compact('marketing'));
    }

    public function adminDashboardMarketingList(){
        $marketing = Marketing::select([
                                'marketings.id',
                                'marketings.name',
                                'marketings.email',
                                'marketings.email_verified_at',
                                'marketings.phone',
                                'marketings.phone_number_verified_at',
                                'marketings.is_active',
                                'marketings.created_at',
                            ])
                            ->with(['detail' => function($query){
                                $query->select([
                                    'detail_marketings.id',
                                    'detail_marketings.id_marketing',
                                    'detail_marketings.jenis_kelamin',
                                    'detail_marketings.no_ktp',
                                ]);
                            }])
                            ->latest()
                            ->get();
        return view('admin.admin_marketing_list', compact('marketing'));
    }

    public function adminDashboardMarketingInvitationCodeList(){
        $invitationCode = InvitationCode::select([
                                            'invitation_codes.id',
                                            'invitation_codes.id_marketing',
                                            'invitation_codes.inv_code',
                                            'invitation_codes.holder',
                                            'invitation_codes.is_active',
                                        ])
                                        ->with(['marketing' => function($query){
                                                    $query->select([
                                                        'marketings.id',
                                                        'marketings.name',
                                                        'marketings.email'
                                                    ]);
                                                },
                                                'tenant' => function($query){
                                                    $query->select([
                                                                'tenants.id',
                                                                'tenants.id_inv_code'
                                                    ]);
                                                }
                                        ])
                                        ->latest()
                                        ->get();
        return view('admin.admin_marketing_invitation_code', compact('invitationCode'));
    }

    public function adminDashboardMarketingInvitationCodeListActivation($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $invitationCode = InvitationCode::find($id);
        if(is_null($invitationCode) || empty($invitationCode) || $invitationCode == NULL){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.marketing.invitationcode')->with($notification);
        }

        $cekMarketing = Marketing::find($invitationCode->id_marketing);

        if($cekMarketing->is_active == 2){
            $notification = array(
                'message' => 'Mitra Aplikasi tidak aktif!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.marketing.invitationcode')->with($notification);
        }

        if($invitationCode->is_active == 0){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Invitation Code | ".$invitationCode->inv_code;
            } else {
                $action = "Administrator : Activating Invitation Code | ".$invitationCode->inv_code;
            }
            $invitationCode->update([
                'is_active' => 1
            ]);
        } else {
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Invitation Code | ".$invitationCode->inv_code;
            } else {
                $action = "Administrator : Deactivating Invitation Code | ".$invitationCode->inv_code;
            }
            $invitationCode->update([
                'is_active' => 0
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'info',
        );
        return redirect()->route('admin.dashboard.marketing.invitationcode')->with($notification);
    }

    public function adminDashboardMarketingInvitationCodeStoreList($id){
        $storeList = InvitationCode::select([
                                        'invitation_codes.id',
                                        'invitation_codes.id_marketing',
                                        'invitation_codes.inv_code',
                                        'invitation_codes.holder',
                                        'invitation_codes.is_active',
                                    ])
                                    ->with([
                                        'marketing' => function($query){
                                            $query->select([
                                                'marketings.id',
                                                'marketings.name'
                                            ]);
                                        },
                                        'tenant' => function($query){
                                            $query->select([
                                                'tenants.id',
                                                'tenants.name',
                                                'tenants.created_at',
                                                'tenants.id_inv_code',
                                                'tenants.is_active'
                                            ])
                                            ->with([
                                                'storeDetail'=> function($query){
                                                    $query->select([
                                                        'store_details.id',
                                                        'store_details.store_identifier',
                                                        'store_details.id_tenant',
                                                        'store_details.name',
                                                        'store_details.jenis_usaha',
                                                        'store_details.status_umi',
                                                    ]);
                                                }
                                            ])
                                            ->latest()
                                            ->get();
                                        }
                                    ])
                                    ->find($id);

        if(is_null($storeList) || empty($storeList) || $storeList == NULL){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.marketing.invitationcode')->with($notification);
        }
        return view('admin.admin_marketing_invitation_code_store_list', compact('storeList'));
    }

    public function adminDashboardMarketingInvitationCodeIncomeList($id){
        $storeList = InvitationCode::select([
                                        'invitation_codes.id',
                                        'invitation_codes.id_marketing',
                                        'invitation_codes.inv_code',
                                        'invitation_codes.holder',
                                        'invitation_codes.is_active',
                                    ])
                                    ->with([
                                        'marketing' => function($query){
                                            $query->select([
                                                'marketings.id',
                                                'marketings.name'
                                            ]);
                                        },
                                        'tenant' => function($query){
                                            $query->select([
                                                'tenants.id',
                                                'tenants.email',
                                                'tenants.name',
                                                'tenants.created_at',
                                                'tenants.id_inv_code',
                                                'tenants.is_active'
                                            ])
                                            ->with([
                                                'storeDetail'=> function($query){
                                                    $query->select([
                                                        'store_details.id',
                                                        'store_details.store_identifier',
                                                        'store_details.id_tenant',
                                                        'store_details.name',
                                                    ]);
                                                },
                                                'withdrawal' => function($query){
                                                    $query->select([
                                                        'withdrawals.id',
                                                        'withdrawals.id_user',
                                                        'withdrawals.invoice_pemarikan',
                                                        'withdrawals.email',
                                                        'withdrawals.tanggal_penarikan',
                                                        'withdrawals.nominal',
                                                        'withdrawals.biaya_admin',
                                                        'withdrawals.status',
                                                    ])
                                                    ->with([
                                                        'detailWithdraw' => function($query){
                                                            $query->select([
                                                                'detail_penarikans.id',
                                                                'detail_penarikans.id_penarikan',
                                                                'detail_penarikans.nominal_bersih_penarikan',
                                                                'detail_penarikans.biaya_nobu',
                                                                'detail_penarikans.biaya_mitra',
                                                                'detail_penarikans.biaya_tenant',
                                                                'detail_penarikans.biaya_admin_su',
                                                                'detail_penarikans.biaya_agregate',
                                                            ]);
                                                        }
                                                    ]);
                                                }
                                            ])
                                            ->latest()
                                            ->get();
                                        }
                                    ])
                                    ->find($id);
        $pemasukan = 0;
        foreach($storeList->tenant as $tenant){
            foreach($tenant->withdrawal as $wdList){
                $pemasukan+=$wdList->detailWithdraw->biaya_mitra;
            }
        }

        return view('admin.admin_marketing_invitation_code_income_list', compact(['storeList', 'pemasukan']));
    }

    public function adminDashboardMarketingWithdrawalList(){
        $marketingWD = Marketing::select([
                                'marketings.id',
                                'marketings.name',
                                'marketings.email',
                            ])
                            ->with(['withdraw' => function($query){
                                $query->select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.email',
                                    'withdrawals.jenis_penarikan',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                    'withdrawals.created_at',
                                    'withdrawals.updated_at',
                                ])
                                ->latest()
                                ->get();
                            }])
                            ->get();
        return view('admin.admin_marketing_withdraw', compact('marketingWD'));
    }

    public function adminDashboardMitraBisnis(){
        $tenant = Tenant::select(['tenants.id',
                                  'tenants.name',
                                  'tenants.email',
                                  'tenants.phone',
                                  'tenants.email_verified_at',
                                  'tenants.phone_number_verified_at',
                                  'tenants.is_active',
                                  'tenants.created_at'])
                            ->where('id_inv_code', 0)
                            ->withCount(['storeList'])
                            ->withCount(['withdrawal'])
                            ->with(['storeList' => function($query){
                                    $query->select([
                                        'store_lists.id',
                                        'store_lists.id_user',
                                        'store_lists.store_identifier'
                                    ])
                                    ->withCount(['invoice']);
                            }])
                            ->latest()
                            ->get();
        $merchantCount=0;
        $withdrawalCount=0;
        $merchantTransactionCount=0;
        $tenantCount = $tenant->count();
        foreach($tenant as $tenantlist){
            $merchantCount+=$tenantlist->store_list_count;
            $withdrawalCount+=$tenantlist->withdrawal_count;
            foreach($tenantlist->storeList as $transactionStore){
                $merchantTransactionCount+=$transactionStore->invoice_count;
            }
        }

        $tenantBaru = $tenant->take(10);
        $tenantActivation = $tenant->where('is_active', 0)->take(10);

        return view('admin.admin_mitra_bisnis_dashboard', compact(['tenantCount', 'merchantCount', 'merchantTransactionCount', 'withdrawalCount', 'tenantBaru', 'tenantActivation']));
    }

    public function adminDashboardMitraBisnisList(){
        $tenantList = Tenant::select(['tenants.id',
                                'tenants.name',
                                'tenants.email',
                                'tenants.phone',
                                'tenants.email_verified_at',
                                'tenants.phone_number_verified_at',
                                'tenants.is_active',
                                'tenants.created_at'])
                        ->where('id_inv_code', 0)
                        ->withCount(['storeList'])
                        ->withCount(['withdrawal'])
                        ->latest()
                        ->get();
        return view('admin.admin_mitra_bisnis_list', compact('tenantList'));
    }

    public function adminDashboardMitraBisnisProfile($id){
        $tenantProfile = Tenant::select([
                                    'tenants.id',
                                    'tenants.name',
                                    'tenants.email',
                                    'tenants.email_verified_at',
                                    'tenants.phone',
                                    'tenants.phone_number_verified_at',
                                    'tenants.is_active'
                                ])
                                ->with([
                                    'detail' => function($query){
                                        $query->select([
                                            'detail_tenants.id',
                                            'detail_tenants.id_tenant',
                                            'detail_tenants.no_ktp',
                                            'detail_tenants.tempat_lahir',
                                            'detail_tenants.tanggal_lahir',
                                            'detail_tenants.jenis_kelamin',
                                            'detail_tenants.alamat',
                                            'detail_tenants.photo',
                                        ]);
                                    }
                                ])
                                ->where('id_inv_code', 0)
                                ->find($id);

        if(is_null($tenantProfile) || empty($tenantProfile)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraBisnis.list')->with($notification);
        }

        return view('admin.admin_mitra_bisnis_profile', compact('tenantProfile'));
    }

    public function adminDashboardMitraBisnisActivation($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $tenant = Tenant::where('id_inv_code', 0)->find($id);
        if(is_null($tenant) || empty($tenant)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraBisnis.list')->with($notification);
        }
        $phone = $tenant->phone;
        if($tenant->is_active == 0){
            if(empty($tenant->phone_number_verified_at) || is_null($tenant->phone_number_verified_at) || $tenant->phone_number_verified_at == NULL || $tenant->phone_number_verified_at == ""){
                $notification = array(
                    'message' => 'Akun gagal diaktifkan, user bersangkutan belum melakukan verifikasi nomor Whatsapp!',
                    'alert-type' => 'warning',
                );
                return redirect()->route('admin.dashboard.mitraBisnis.list')->with($notification);
            }
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Mitra Bisnis | ".$tenant->name;
            } else {
                $action = "Administrator : Activating Mitra Bisnis | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 1
            ]);
            $phone = $tenant->phone;
            $body = "Terima kasih telah mendaftar sebagai Mitra Bisnis pada aplikasi Visioner, akun anda telah sukses diaktifkan oleh admin";
            $this->sendNotificationToUser($body, $phone);
        } else if($tenant->is_active == 1){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Mitra Bisnis | ".$tenant->name;
            } else {
                $action = "Administrator : Deactivating Mitra Bisnis | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 2
            ]);
            $body = "Karena aktivitas yang mencurigakan, admin memutuskan untuk menonaktifkan akun mitra aplikasi anda, Jika anda merasa tidak melakukan aktivitas yang ilegal, segera hubungi Admin untuk proses lebih lanjut!";
            $this->sendNotificationToUser($body, $phone);
        } else if($tenant->is_active == 2){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Reactivating Mitra Bisnis | ".$tenant->name;
            } else {
                $action = "Administrator : Reactivating Mitra Bisnis | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 1
            ]);
            $body = "Akun anda telah sukses di re-aktivasi oleh admin, anda dapat melakukan aktivitas login kembali melalui login form pada website Visipos.";
            $this->sendNotificationToUser($body, $phone);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.mitraBisnis.list')->with($notification);
    }

    public function adminDashboardMitraBisnisMerchantList(){
        $storeList = StoreList::select([
                                'store_lists.id',
                                'store_lists.id_user',
                                'store_lists.email',
                                'store_lists.store_identifier',
                                'store_lists.name',
                                'store_lists.jenis_usaha',
                                'store_lists.status_umi',
                                'store_lists.is_active',
                            ])
                            ->with(['tenant' => function($query){
                                $query->select([
                                    'tenants.id',
                                    'tenants.name',
                                    'tenants.email',
                                ]);
                            }])
                            ->withCount(['invoice'])
                            ->latest()
                            ->get();

        return view('admin.admin_mitra_bisnis_merchant_list', compact('storeList'));
    }

    public function adminDashboardMitraBisnisMerchantInvoiceList($id, $store_identifier){
        $storeList = StoreList::select([
                                    'store_lists.id',
                                    'store_lists.id_user',
                                    'store_lists.store_identifier',
                                    'store_lists.name',
                                ])
                                ->with([
                                    'invoice' => function($query){
                                        $query->select([
                                            'invoices.id',
                                            'invoices.store_identifier',
                                            'invoices.email',
                                            'invoices.id_tenant',
                                            'invoices.nomor_invoice',
                                            'invoices.tanggal_transaksi',
                                            'invoices.tanggal_pelunasan',
                                            'invoices.jenis_pembayaran',
                                            'invoices.status_pembayaran',
                                            'invoices.nominal_bayar',
                                            'invoices.kembalian',
                                            'invoices.mdr',
                                            'invoices.nominal_mdr',
                                            'invoices.nominal_terima_bersih',
                                            'invoices.created_at',
                                            'invoices.updated_at'
                                        ])
                                        ->latest()
                                        ->get();
                                    },
                                    'tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.name'
                                        ]);
                                    }
                                ])
                                ->where('store_identifier', $store_identifier)
                                ->find($id);

        if(is_null($storeList) || empty($storeList)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraBisnis.merchantList')->with($notification);
        }

        return view('admin.admin_mitra_bisnis_merchant_invoice_list', compact('storeList'));
    }

    public function adminDashboardMitraBisnisMerchantDetail($id, $store_identifier){
        $storeDetail = StoreList::select([
                                    'store_lists.id',
                                    'store_lists.id_user',
                                    'store_lists.email',
                                    'store_lists.store_identifier',
                                    'store_lists.name',
                                    'store_lists.alamat',
                                    'store_lists.kabupaten',
                                    'store_lists.kode_pos',
                                    'store_lists.no_telp_toko',
                                    'store_lists.jenis_usaha',
                                    'store_lists.status_umi',
                                    'store_lists.photo',
                                    'store_lists.is_active',
                                ])
                                ->with([
                                    'tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.name'
                                        ]);
                                    }
                                ])
                                ->where('store_identifier', $store_identifier)
                                ->find($id);

        if(is_null($storeDetail) || empty($storeDetail)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraBisnis.merchantList')->with($notification);
        }

        $umiRequest = "";
        $umiRequest = UmiRequest::where('store_identifier', $store_identifier)->first();

        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }

        return view('admin.admin_mitra_bisnis_merchant_detail', compact('storeDetail', 'umiRequest'));
    }

    public function adminDashboardMitraBisnisMerchantActivation($id, $store_identifier){
        DB::connection()->enableQueryLog();
        $action = "";
        $storeActivation = StoreList::where('id', $id)->where('store_identifier', $store_identifier)->first();
        if(is_null($storeActivation) || empty($storeActivation)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraBisnis.merchantList')->with($notification);
        }

        if($storeActivation->is_active == 0){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Merchant | ".$storeActivation->store_identifier;
            } else {
                $action = "Administrator : Activating Merchant | ".$storeActivation->store_identifier;
            }
            $storeActivation->update([
                'is_active' => 1
            ]);
        } else if($storeActivation->is_active == 1){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Merchant | ".$storeActivation->store_identifier;
            } else {
                $action = "Administrator : Deactivating Merchant | ".$storeActivation->store_identifier;
            }
            $storeActivation->update([
                'is_active' => 0
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.mitraBisnis.merchantList')->with($notification);
    }

    public function adminDashboardMitraBisnisUMIList(){
        $umi = Tenant::select([
                        'tenants.id',
                        'tenants.name',
                    ])
                    ->with([
                        'storeListUMI' => function($query){
                            $query->select([
                                'umi_requests.id',
                                'umi_requests.id_tenant',
                                'umi_requests.store_identifier',
                                'umi_requests.tanggal_pengajuan',
                                'umi_requests.tanggal_approval',
                                'umi_requests.is_active',
                                'umi_requests.file_path',
                                'umi_requests.note',
                            ])
                            ->with([
                                'storeList' => function($query){
                                    $query->select([
                                        'store_lists.id',
                                        'store_lists.id_user',
                                        'store_lists.store_identifier',
                                        'store_lists.name',
                                        'store_lists.jenis_usaha',
                                        'store_lists.status_umi',
                                        'store_lists.is_active',
                                    ]);
                                }
                            ])
                            ->orderBy('umi_requests.tanggal_approval', 'DESC')
                            ->get();
                        }
                    ])
                    ->where('is_active', 1)
                    ->where('id_inv_code', 0)
                    ->latest()
                    ->get();
        return view('admin.admin_mitra_bisnis_merchant_umi_list', compact('umi'));
    }

    public function adminDashboardMitraBisnisQrisList(){
        $qris = Tenant::select([
                            'tenants.id',
                            'tenants.name',
                            'tenants.email'
                        ])
                        ->with([
                            'tenantQrisAccountStoreList' => function($query){
                                $query->select([
                                    'tenant_qris_accounts.id',
                                    'tenant_qris_accounts.store_identifier',
                                    'tenant_qris_accounts.qris_login_user',
                                    'tenant_qris_accounts.qris_password',
                                    'tenant_qris_accounts.qris_merchant_id',
                                    'tenant_qris_accounts.qris_store_id',
                                    'tenant_qris_accounts.mdr',
                                ])
                                ->with([
                                    'storeList' => function($query){
                                        $query->select([
                                            'store_lists.id',
                                            'store_lists.store_identifier',
                                            'store_lists.name',
                                        ]);
                                    }
                                ])
                                ->orderBy('tenant_qris_accounts.created_at', 'DESC')
                                ->get();
                            }
                        ])
                        ->where('is_active', 1)
                        ->where('id_inv_code', 0)
                        ->latest()
                        ->get();

        return view('admin.admin_mitra_bisnis_merchant_qris_list', compact('qris'));
    }

    public function adminDashboardMitraBisnisTransactionList(Request $request){
        if ($request->ajax()) {
            $data = Invoice::select([
                                        'invoices.id',
                                        'invoices.store_identifier',
                                        'invoices.email',
                                        'invoices.id_tenant',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.nominal_bayar',
                                        'invoices.kembalian',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                        'invoices.created_at',
                                        'invoices.updated_at'
                                    ])
                                    ->with([
                                        'tenant' => function($query){
                                            $query->select([
                                                'tenants.id',
                                                'tenants.name'
                                            ]);
                                        },
                                        'storeMitra' => function($query){
                                            $query->select([
                                                'store_lists.id',
                                                'store_lists.id_user',
                                                'store_lists.email',
                                                'store_lists.store_identifier',
                                                'store_lists.name',
                                            ]);
                                        }
                                    ])
                                    ->whereHas('tenant', function($query){
                                        $query->where('id_inv_code', '==', 0);
                                    })
                                    ->latest()
                                    ->get();
            
            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('nomor_invoice', function($data) {
                                    return $data->nomor_invoice;
                                })
                                ->editColumn('tenant', function($data) {
                                    return $data->tenant->name;
                                })
                                ->editColumn('store_identifier', function($data) {
                                    return $data->store_identifier;
                                })
                                ->editColumn('merchant_name', function($data) {
                                    return $data->storeMitra->name;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status_pembayaran == 1)?'<span class="badge bg-soft-success text-success">Selesai</span>':'<span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>');
                                })
                                ->rawColumns(['status'])
                                ->editColumn('tanggal_transaksi', function($data) {
                                    $date = \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->created_at)->format('H:i:s');
                                    $dateTimeTransaksi = $date." ".$time;
                                    return $dateTimeTransaksi;
                                })
                                ->editColumn('tanggal_pembayaran', function($data) {
                                    $date = \Carbon\Carbon::parse($data->tanggal_pelunasan)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->updated_at)->format('H:i:s');
                                    $dateTimePembayaran = $date." ".$time;
                                    return $dateTimePembayaran;
                                })
                                ->editColumn('jenis_pembayaran', function($data) {
                                    return $data->jenis_pembayaran;
                                })
                                ->editColumn('nominal_bayar', function($data) {
                                    return $data->nominal_bayar;
                                })
                                ->editColumn('mdr', function($data) {
                                    return $data->mdr;
                                })
                                ->editColumn('nominal_mdr', function($data) {
                                    return $data->nominal_mdr;
                                })
                                ->editColumn('nominal_terima_bersih', function($data) {
                                    return $data->nominal_terima_bersih;
                                })
                                ->make(true);
        }
        return view('admin.admin_mitra_bisnis_transaction_list');
        // $tenantInvoice = Tenant::select(['tenants.id', 'tenants.name'])
        //                         ->where('id_inv_code', 0)
        //                         ->with([
        //                             'storeList' => function($query){
        //                                 $query->select([
        //                                     'store_lists.id',
        //                                     'store_lists.id_user',
        //                                     'store_lists.email',
        //                                     'store_lists.store_identifier',
        //                                     'store_lists.name',
        //                                 ])
        //                                 ->with([
        //                                     'invoice' => function($query){
        //                                         $query->select([
        //                                             'invoices.id',
        //                                             'invoices.store_identifier',
        //                                             'invoices.email',
        //                                             'invoices.id_tenant',
        //                                             'invoices.nomor_invoice',
        //                                             'invoices.tanggal_transaksi',
        //                                             'invoices.tanggal_pelunasan',
        //                                             'invoices.jenis_pembayaran',
        //                                             'invoices.status_pembayaran',
        //                                             'invoices.nominal_bayar',
        //                                             'invoices.kembalian',
        //                                             'invoices.mdr',
        //                                             'invoices.nominal_mdr',
        //                                             'invoices.nominal_terima_bersih',
        //                                             'invoices.created_at',
        //                                             'invoices.updated_at'
        //                                         ])
        //                                         ->latest()
        //                                         ->get();
        //                                     }
        //                                 ]);
        //                             }
        //                         ])
        //                         ->get();
        // return view('admin.admin_mitra_bisnis_transaction_list', compact('tenantInvoice'));
    }

    public function adminDashboardMitraBisnisWithdrawalList(){
        $tenantWithdraw = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email'])
                                ->with(['withdrawal' => function($query){
                                    $query->select([
                                        'withdrawals.id',
                                        'withdrawals.invoice_pemarikan',
                                        'withdrawals.email',
                                        'withdrawals.jenis_penarikan',
                                        'withdrawals.tanggal_penarikan',
                                        'withdrawals.nominal',
                                        'withdrawals.biaya_admin',
                                        'withdrawals.status',
                                        'withdrawals.created_at',
                                        'withdrawals.updated_at',
                                    ])
                                    ->latest()
                                    ->get();
                                }])
                                ->where('id_inv_code', 0)
                                ->get();

        return view('admin.admin_mitra_bisnis_withdrawal_list', compact('tenantWithdraw'));
    }

    public function adminDashboardMitraTenant(){
        $tenant = Tenant::select([
                                'tenants.id',
                                'tenants.name',
                                'tenants.email',
                                'tenants.phone',
                                'tenants.email_verified_at',
                                'tenants.phone_number_verified_at',
                                'tenants.is_active',
                                'tenants.created_at'
                            ])
                            ->where('id_inv_code', '!=' ,0)
                            ->withCount(['storeDetail'])
                            ->withCount(['withdrawal'])
                            ->with([
                                'storeDetail' => function($query){
                                    $query->select([
                                        'store_details.id',
                                        'store_details.id_tenant',
                                        'store_details.store_identifier'
                                    ])
                                    ->withCount(['invoice']);
                                },
                            ])
                            ->latest()
                            ->get();
        $storeCount=0;
        $withdrawalCount=0;
        $merchantTransactionCount=0;
        $tenantCount = $tenant->count();
        foreach($tenant as $tenantlist){
            $storeCount+=$tenantlist->store_detail_count;
            $withdrawalCount+=$tenantlist->withdrawal_count;
            $merchantTransactionCount+=$tenantlist->storeDetail->invoice_count;
        }

        $tenantBaru = $tenant->take(10);
        $kasir = Kasir::count();

        $tenantWithdrawNew = Withdrawal::select([
                                            'withdrawals.id',
                                            'withdrawals.invoice_pemarikan',
                                            'withdrawals.id_user',
                                            'withdrawals.email',
                                            'withdrawals.tanggal_penarikan',
                                            'withdrawals.nominal',
                                            'withdrawals.biaya_admin',
                                            'withdrawals.status',
                                        ])
                                        ->with(['tenant' => function($query){
                                                    $query->select([
                                                        'tenants.id',
                                                        'tenants.name',
                                                        'tenants.email',
                                                    ]);
                                                },
                                                'detailWithdraw' => function($query){
                                                    $query->select([
                                                        'detail_penarikans.id',
                                                        'detail_penarikans.id_penarikan',
                                                        'detail_penarikans.nominal_bersih_penarikan',
                                                        'detail_penarikans.biaya_nobu',
                                                        'detail_penarikans.biaya_mitra',
                                                        'detail_penarikans.biaya_tenant',
                                                        'detail_penarikans.biaya_admin_su',
                                                        'detail_penarikans.biaya_agregate',
                                                    ]);
                                                }
                                        ])
                                        ->whereHas('tenant', function($query){
                                            $query->where('id_inv_code', '!=', 0);
                                        })
                                        ->take(10)
                                        ->latest()
                                        ->get();
        return view('admin.admin_mitra_tenant_dashboard', compact(['tenantCount', 'storeCount', 'withdrawalCount', 'merchantTransactionCount', 'kasir', 'tenantBaru', 'tenantWithdrawNew']));
    }

    public function adminDashboardMitraTenantList(){
        $tenantMitra = Tenant::select([
                                    'tenants.id',
                                    'tenants.name',
                                    'tenants.email',
                                    'tenants.email_verified_at',
                                    'tenants.phone',
                                    'tenants.phone_number_verified_at',
                                    'tenants.is_active',
                                    'tenants.id_inv_code',
                                    'tenants.created_at'
                                ])
                                ->with([
                                    'detail' => function($query){
                                        $query->select([
                                            'detail_tenants.id',
                                            'detail_tenants.id_tenant',
                                            'detail_tenants.email',
                                            'detail_tenants.jenis_kelamin',
                                        ]);
                                    },
                                    'invitationCode' => function($query){
                                        $query->select([
                                            'invitation_codes.id',
                                            'invitation_codes.id_marketing',
                                            'invitation_codes.inv_code',
                                            'invitation_codes.holder',
                                        ])
                                        ->with([
                                            'marketing' => function($query){
                                                $query->select([
                                                    'marketings.id',
                                                    'marketings.name',
                                                ]);
                                            }
                                        ]);
                                    }
                                ])
                                ->withCount(['withdrawal'])
                                ->withCount(['invoice'])
                                ->where('id_inv_code', '!=', 0)
                                ->latest()
                                ->get();
        return view('admin.admin_mitra_tenant_list', compact(['tenantMitra']));
    }

    public function adminDashboardMitraTenantDetail($id){
        $tenantDetail = Tenant::select([
                                'tenants.id',
                                'tenants.name',
                                'tenants.email',
                                'tenants.phone',
                                'tenants.email_verified_at',
                                'tenants.phone_number_verified_at',
                                'tenants.is_active',
                            ])
                            ->with([
                                'detail' => function($query){
                                    $query->select([
                                        'detail_tenants.id',
                                        'detail_tenants.id_tenant',
                                        'detail_tenants.no_ktp',
                                        'detail_tenants.tempat_lahir',
                                        'detail_tenants.tanggal_lahir',
                                        'detail_tenants.jenis_kelamin',
                                        'detail_tenants.alamat',
                                        'detail_tenants.photo',
                                    ]);
                                }
                            ])
                            ->where('id_inv_code', '!=', 0)
                            ->find($id);

        if(is_null($tenantDetail) || empty($tenantDetail)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.list')->with($notification);
        }

        return view('admin.admin_mitra_tenant_detail', compact(['tenantDetail']));
    }

    public function adminDashboardMitraTenantActivation($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $tenant = Tenant::where('id_inv_code', '!=', 0)->find($id);
        if(is_null($tenant) || empty($tenant)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.list')->with($notification);
        }
        $phone = $tenant->phone;
        if($tenant->is_active == 0){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Tenant | ".$tenant->name;
            } else {
                $action = "Administrator : Activating Tenant | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 1
            ]);
            $body = "Terima kasih telah mendaftar sebagai Mitra Tenant pada aplikasi Visioner, akun anda telah sukses diaktifkan oleh admin";
            $this->sendNotificationToUser($body, $phone);
        } else if($tenant->is_active == 1){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Tenant | ".$tenant->name;
            } else {
                $action = "Administrator : Deactivating Tenant | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 2
            ]);
            $body = "Karena aktivitas yang mencurigakan, admin memutuskan untuk menonaktifkan akun mitra aplikasi anda, Jika anda merasa tidak melakukan aktivitas yang ilegal, segera hubungi Admin untuk proses lebih lanjut!";
            $this->sendNotificationToUser($body, $phone);
        } else if($tenant->is_active == 2){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Reactivating Tenant | ".$tenant->name;
            } else {
                $action = "Administrator : Reactivating Tenant | ".$tenant->name;
            }
            $tenant->update([
                'is_active' => 1
            ]);
            $body = "Akun anda telah sukses di re-aktivasi oleh admin, anda dapat melakukan aktivitas login kembali melalui login form pada website Visipos.";
            $this->sendNotificationToUser($body, $phone);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );

        return redirect()->route('admin.dashboard.mitraTenant.list')->with($notification);
    }

    public function adminDashboardMitraTenantStoreList(){
        $storeDetail = StoreDetail::select([
                                    'store_details.id',
                                    'store_details.store_identifier',
                                    'store_details.id_tenant',
                                    'store_details.email',
                                    'store_details.name',
                                    'store_details.jenis_usaha',
                                    'store_details.status_umi',
                                ])
                                ->with([
                                    'tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.name',
                                            'tenants.email'
                                        ]);
                                    }
                                ])
                                ->withCount(['invoice'])
                                ->latest()
                                ->get();
        return view('admin.admin_mitra_tenant_store_list', compact(['storeDetail']));
    }

    public function adminDashboardMitraTenantStoreInvoiceList($id, $store_identifier){
        $storeDetail = StoreDetail::select([
                                    'store_details.id',
                                    'store_details.id_tenant',
                                    'store_details.store_identifier',
                                    'store_details.name',
                                ])
                                ->with([
                                    'invoice' => function($query){
                                        $query->select([
                                            'invoices.id',
                                            'invoices.store_identifier',
                                            'invoices.email',
                                            'invoices.id_tenant',
                                            'invoices.nomor_invoice',
                                            'invoices.tanggal_transaksi',
                                            'invoices.tanggal_pelunasan',
                                            'invoices.jenis_pembayaran',
                                            'invoices.status_pembayaran',
                                            'invoices.nominal_bayar',
                                            'invoices.kembalian',
                                            'invoices.mdr',
                                            'invoices.nominal_mdr',
                                            'invoices.nominal_terima_bersih',
                                            'invoices.created_at',
                                            'invoices.updated_at',
                                        ])
                                        ->latest()
                                        ->get();
                                    },
                                    'tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.name'
                                        ]);
                                    }
                                ])
                                ->where('store_identifier', $store_identifier)
                                ->find($id);
        if(is_null($storeDetail) || empty($storeDetail)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.store.list')->with($notification);
        }

        return view('admin.admin_mitra_tenant_store_invoice', compact('storeDetail'));
    }

    public function adminDashboardMitraTenantStoreDetail($id, $store_identifier){
        $storeDetail = StoreDetail::select([
                                        'store_details.id',
                                        'store_details.id_tenant',
                                        'store_details.email',
                                        'store_details.store_identifier',
                                        'store_details.name',
                                        'store_details.alamat',
                                        'store_details.kabupaten',
                                        'store_details.kode_pos',
                                        'store_details.no_telp_toko',
                                        'store_details.jenis_usaha',
                                        'store_details.status_umi',
                                        'store_details.photo',
                                    ])
                                    ->with([
                                        'tenant' => function($query){
                                            $query->select([
                                                'tenants.id',
                                                'tenants.name'
                                            ]);
                                        }
                                    ])
                                    ->where('store_identifier', $store_identifier)
                                    ->find($id);

        if(is_null($storeDetail) || empty($storeDetail)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.store.lis')->with($notification);
        }

        $umiRequest = "";
        $umiRequest = UmiRequest::where('store_identifier', $store_identifier)->first();

        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }

        return view('admin.admin_mitra_tenant_store_detail', compact('storeDetail', 'umiRequest'));
    }

    public function adminDashboardMitraTenantKasirList(){
        $kasir = Kasir::select([
                        'kasirs.id',
                        'kasirs.name',
                        'kasirs.email',
                        'kasirs.phone',
                        'kasirs.is_active',
                        'kasirs.id_store'
                    ])
                    ->with([
                        'detail' => function($query){
                            $query->select([
                                'detail_kasirs.id',
                                'detail_kasirs.id_kasir',
                                'detail_kasirs.jenis_kelamin',
                            ]);
                        },
                        'store' => function($query){
                            $query->select([
                                'store_details.id',
                                'store_details.store_identifier',
                                'store_details.id_tenant',
                                'store_details.name',
                            ])
                            ->with([
                                'tenant' => function($query){
                                    $query->select([
                                        'tenants.id',
                                        'tenants.name'
                                    ]);
                                }
                            ]);
                        }
                    ])
                    ->latest()
                    ->get();
        return view('admin.admin_mitra_tenant_kasir_list', compact(['kasir']));
    }

    public function adminDashboardMitraTenantKasirProfile($id){
        $kasirDetail = Kasir::select([
                                'kasirs.id',
                                'kasirs.name',
                                'kasirs.email',
                                'kasirs.phone',
                                'kasirs.is_active'
                            ])
                            ->with([
                                'detail' => function($query){
                                    $query->select([
                                        'detail_kasirs.id',
                                        'detail_kasirs.id_kasir',
                                        'detail_kasirs.no_ktp',
                                        'detail_kasirs.tempat_lahir',
                                        'detail_kasirs.tanggal_lahir',
                                        'detail_kasirs.jenis_kelamin',
                                        'detail_kasirs.alamat',
                                        'detail_kasirs.photo',
                                    ]);
                                }
                            ])
                            ->find($id);

        if(is_null($kasirDetail) || empty($kasirDetail)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.kasir.list')->with($notification);
        }

        return view('admin.admin_mitra_tenant_kasir_detail', compact('kasirDetail'));
    }

    public function adminDashboardMitraTenantKasirActivation($id){
        DB::connection()->enableQueryLog();
        $action = "";
        $kasir = Kasir::find($id);
        if(is_null($kasir) || empty($kasir)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.mitraTenant.kasir.list')->with($notification);
        }

        if($kasir->is_active == 0) {
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Activating Kasir | ".$kasir->name;
            } else {
                $action = "Administrator : Activating Kasir | ".$kasir->name;
            }
            $kasir->update([
                'is_active' => 1
            ]);
        } else if($kasir->is_active == 1){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Deactivating Kasir | ".$kasir->name;
            } else {
                $action = "Administrator : Deactivating Kasir | ".$kasir->name;
            }
            $kasir->update([
                'is_active' => 0
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.mitraTenant.kasir.list')->with($notification);

    }

    public function adminDashboardMitraTenantUMIList(){
        $umi = Tenant::select([
                                'tenants.id',
                                'tenants.name',
                            ])
                            ->with([
                                'storeDetailUMI' => function($query){
                                    $query->select([
                                        'umi_requests.id',
                                        'umi_requests.id_tenant',
                                        'umi_requests.store_identifier',
                                        'umi_requests.tanggal_pengajuan',
                                        'umi_requests.tanggal_approval',
                                        'umi_requests.is_active',
                                        'umi_requests.file_path',
                                        'umi_requests.note',
                                    ])
                                    ->with([
                                        'storeDetail' => function($query){
                                            $query->select([
                                                'store_details.id',
                                                'store_details.id_tenant',
                                                'store_details.store_identifier',
                                                'store_details.name',
                                                'store_details.jenis_usaha',
                                                'store_details.status_umi',
                                            ]);
                                        }
                                    ])
                                    ->orderBy('umi_requests.tanggal_approval', 'DESC')
                                    ->get();
                                }
                            ])
                            ->where('is_active', 1)
                            ->where('id_inv_code', '!=', 0)
                            ->latest()
                            ->get();
        return view('admin.admin_mitra_tenant_umi_list', compact('umi'));
    }

    public function adminDashboardMitraTenantQrisList(){
        $qris = Tenant::select([
                            'tenants.id',
                            'tenants.name',
                            'tenants.email'
                        ])
                        ->with([
                            'tenantQrisAccountStoreDetail' => function($query){
                                $query->select([
                                    'tenant_qris_accounts.id',
                                    'tenant_qris_accounts.store_identifier',
                                    'tenant_qris_accounts.qris_login_user',
                                    'tenant_qris_accounts.qris_password',
                                    'tenant_qris_accounts.qris_merchant_id',
                                    'tenant_qris_accounts.qris_store_id',
                                    'tenant_qris_accounts.mdr',
                                ])
                                ->with([
                                    'storeDetail' => function($query){
                                        $query->select([
                                            'store_details.id',
                                            'store_details.store_identifier',
                                            'store_details.name',
                                        ]);
                                    }
                                ])
                                ->orderBy('tenant_qris_accounts.created_at', 'DESC')
                                ->get();
                            }
                        ])
                        ->where('is_active', 1)
                        ->where('id_inv_code', '!=',0)
                        ->latest()
                        ->get();

        return view('admin.admin_mitra_tenant_qris_list', compact('qris'));
    }

    public function adminDashboardMitraTenantTransactionList(){
        $tenantInvoice = Tenant::select(['tenants.id', 'tenants.name'])
                                ->where('id_inv_code', '!=', 0)
                                ->with([
                                    'storeDetail' => function($query){
                                        $query->select([
                                            'store_details.id',
                                            'store_details.id_tenant',
                                            'store_details.email',
                                            'store_details.store_identifier',
                                            'store_details.name',
                                        ])
                                        ->with([
                                            'invoice' => function($query){
                                                $query->select([
                                                    'invoices.id',
                                                    'invoices.store_identifier',
                                                    'invoices.nomor_invoice',
                                                    'invoices.tanggal_transaksi',
                                                    'invoices.tanggal_pelunasan',
                                                    'invoices.jenis_pembayaran',
                                                    'invoices.status_pembayaran',
                                                    'invoices.sub_total',
                                                    'invoices.pajak',
                                                    'invoices.diskon',
                                                    'invoices.nominal_bayar',
                                                    'invoices.kembalian',
                                                    'invoices.mdr',
                                                    'invoices.nominal_mdr',
                                                    'invoices.nominal_terima_bersih',
                                                    'invoices.created_at',
                                                    'invoices.updated_at',
                                                ])
                                                ->latest()
                                                ->get();
                                            }
                                        ]);
                                    }
                                ])
                                ->get();
        return view('admin.admin_mitra_tenant_transaction_list', compact('tenantInvoice'));
    }

    public function adminDashboardMitraTenantWithdrawalList(){
        $tenantWithdraw = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email'])
                                ->with(['withdrawal' => function($query){
                                    $query->select([
                                        'withdrawals.id',
                                        'withdrawals.invoice_pemarikan',
                                        'withdrawals.email',
                                        'withdrawals.jenis_penarikan',
                                        'withdrawals.tanggal_penarikan',
                                        'withdrawals.nominal',
                                        'withdrawals.biaya_admin',
                                        'withdrawals.status',
                                        'withdrawals.created_at',
                                        'withdrawals.updated_at',
                                    ])
                                    ->latest()
                                    ->get();
                                }])
                                ->where('id_inv_code', '!=', 0)
                                ->latest()
                                ->get();
        return view('admin.admin_mitra_tenant_withdrawal_list', compact('tenantWithdraw'));
    }

    public function adminDashboardFinance(){
        $adminQrisWallet = QrisWallet::select(['saldo'])->where('email', auth()->user()->email)->find(auth()->user()->id);
        $agregateWallet = AgregateWallet::select(['saldo'])->first();
        $withdrawData = Withdrawal::where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->latest();
        $allData = $withdrawData->get();
        $allDataSum = $withdrawData->sum('nominal');
        return view('admin.admin_finance_history', compact(['adminQrisWallet', 'agregateWallet', 'allData', 'allDataSum']));
    }

    public function adminDashboardFinanceInvoice($id){
        $withdrawData = Withdrawal::select([
                                    'withdrawals.id',
                                    'withdrawals.id_rekening',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.jenis_penarikan',
                                    'withdrawals.email',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                    'withdrawals.created_at',
                                ])
                                ->with([
                                    'detailWithdraw' => function($query){
                                        $query->select([
                                            'detail_penarikans.id',
                                            'detail_penarikans.id_insentif',
                                            'detail_penarikans.id_penarikan',
                                            'detail_penarikans.nominal'
                                        ])
                                        ->with([
                                            'insentif' => function($query){
                                                $query->select([
                                                    'biaya_admin_transfer_danas.id',
                                                    'biaya_admin_transfer_danas.jenis_insentif',
                                                ]);
                                            }
                                        ]);
                                    },
                                    'rekAdmin' => function($query){
                                        $query->select([
                                            'rekening_admins.id',
                                            'rekening_admins.nama_rekening',
                                            'rekening_admins.nama_bank',
                                            'rekening_admins.no_rekening',
                                        ]);
                                    }
                                ])
                                ->where('email', auth()->user()->email)
                                ->find($id);
        if(is_null($withdrawData) || empty($withdrawData)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->route('admin.dashboard.finance')->with($notification);
        }
        return view('admin.admin_finance_history_invoice', compact(['withdrawData']));
    }

    public function adminDashboardInsentifSettingList(){
        $insentifTransfer = BiayaAdminTransferDana::get();
        $totalInsentif = $insentifTransfer->sum('nominal');

        return view('admin.admin_finance_insentif_setting_list', compact(['totalInsentif', 'insentifTransfer']));
    }

    public function adminDashboardInsentifSettingInsert(Request $request){
        $action = "";
        DB::connection()->enableQueryLog();
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Add New Insentif Setting";
        }
        BiayaAdminTransferDana::create([
            'jenis_insentif' => $request->name,
            'nominal' => $request->nominal_insentif
        ]);
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.finance.insentif.list')->with($notification);
    }

    public function adminDashboardInsentifSettingUpdate(Request $request){
        $action = "";
        DB::connection()->enableQueryLog();
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Update Data Insentif";
        }
        $insentifTransfer = BiayaAdminTransferDana::find($request->id);
        if(is_null($insentifTransfer) || empty($insentifTransfer)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.finance.insentif.list')->with($notification);
        }

        $insentifTransfer->update([
            'jenis_insentif' => $request->name,
            'nominal' => $request->nominal_insentif
        ]);

        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );

        return redirect()->route('admin.dashboard.finance.insentif.list')->with($notification);
    }

    public function adminDashboardInsentifSettingDelete($id){
        $action = "";
        DB::connection()->enableQueryLog();
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Hapus Data Insentif";
        }
        $insentifTransfer = BiayaAdminTransferDana::find($id);
        if(is_null($insentifTransfer) || empty($insentifTransfer)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.finance.insentif.list')->with($notification);
        }
        $insentifTransfer->delete();
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'info',
        );

        return redirect()->route('admin.dashboard.finance.insentif.list')->with($notification);
    }

    public function adminDashboardSettlementSettingList(){
        $settlementList = SettlementDateSetting::latest()->get();
        return view('admin.admin_finance_settlement_setting_list', compact(['settlementList']));
    }

    public function adminDashboardSettlementSettingListInsert(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $note = $request->note;
        $dateCheck = Carbon::parse($start_date);

        if($end_date<$start_date || $dateCheck->isYesterday()){
            $notification = array(
                'message' => 'Inputan tanggal salah atau tidak sesuai!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        } else {
            SettlementDateSetting::create([
                'stat_date' => $start_date,
                'end_date' => $end_date,
                'note' => $note
            ]);
            $action = "";
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Add Settlement Holiday Date";
            } else {
                $action = "Administrator : Add Settlement Holiday Date";
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data berhasil ditambahkan!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function adminDashboardSettlementDelete($id){
        $settlementSetting = SettlementDateSetting::find($id);
        if(is_null($settlementSetting) || empty($settlementSetting)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $settlementSetting->delete();
        $notification = array(
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.finance.settlement.list')->with($notification);
    }

    public function adminDashboardSettlementSettingListUpdate(Request $request){
        $id = $request->id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $note = $request->note;
        $dateCheck = Carbon::parse($start_date);

        if($end_date<$start_date || $dateCheck->isYesterday()){
            $notification = array(
                'message' => 'Inputan tanggal salah atau tidak sesuai!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        } else {
            $settlement = SettlementDateSetting::find($id);

            if(is_null($settlement) || empty($settlement)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }

            $settlement->update([
                'stat_date' => $start_date,
                'end_date' => $end_date,
                'note' => $note
            ]);

            $action = "";
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Update Settlement Holiday Date";
            } else {
                $action = "Administrator : Update Settlement Holiday Date";
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function adminDashboardSettlementPending(){
        $settlemetHistory = SettlementPending::where('settlement_pending_status', 0)->latest()->get();
        return view('admin.admin_finance_settlement_pending', compact('settlemetHistory'));
    }

    public function adminDashboardSettlementHistory(){
        $settlement = Settlement::withSum('settlementHistory', 'nominal_settle')
                                ->withSum('settlementHistory', 'nominal_insentif_cashback')
                                ->latest()
                                ->get();
        return view('admin.admin_finance_settlement_history_list', compact('settlement'));
    }

    public function adminDashboardSettlementHistoryDetail($id, $code){
        $settlementDetailHistory = Settlement::select([
                                                    'settlements.id',
                                                    'settlements.nomor_settlement',
                                                    'settlements.tanggal_settlement',
                                                ])
                                                ->withSum('settlementHistory', 'nominal_settle')
                                                ->withSum('settlementHistory', 'nominal_insentif_cashback')
                                                ->with([
                                                    'settlementHistory' => function($query){
                                                        $query->select([
                                                            'settlement_hstories.id',
                                                            'settlement_hstories.id_user',
                                                            'settlement_hstories.id_settlement',
                                                            'settlement_hstories.email',
                                                            'settlement_hstories.settlement_time_stamp',
                                                            'settlement_hstories.nominal_settle',
                                                            'settlement_hstories.nominal_insentif_cashback',
                                                            'settlement_hstories.status',
                                                            'settlement_hstories.note',
                                                        ])
                                                        ->with([
                                                            'tenant' => function($query){
                                                                $query->select([
                                                                    'tenants.id',
                                                                    'tenants.name',
                                                                    'tenants.email'
                                                                ]);
                                                            }
                                                        ])
                                                        ->latest()
                                                        ->get();
                                                    }
                                                ])
                                                ->where('nomor_settlement', $code)
                                                ->find($id);
        if(is_null($settlementDetailHistory) || empty($settlementDetailHistory)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        return view('admin.admin_finance_settlement_history_detail', compact('settlementDetailHistory'));
    }

    public function adminDashboardMitraBisnisTransactionListTesting(Request $request){
        if ($request->ajax()) {
            // $data = Invoice::select(['id', 'store_identifier', 'email']);
            // $data = Tenant::select(['tenants.id', 'tenants.name'])
            //                         ->with([
            //                             'storeList' => function($query){
            //                                 $query->select([
            //                                     'store_lists.id',
            //                                     'store_lists.id_user',
            //                                     'store_lists.email',
            //                                     'store_lists.store_identifier',
            //                                     'store_lists.name',
            //                                 ]);
            //                             }
            //                         ])
            //                         ->where('id_inv_code', 0)
            //                         ->get();
            // return Datatables::of($data)
            //             ->addIndexColumn()
            //             ->addColumn('action', function($row){
            //                 $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            //                 return $actionBtn;
            //             })
            //             ->rawColumns(['action'])
            //             ->make(true);
            $data = Invoice::select([
                                        'invoices.id',
                                        'invoices.store_identifier',
                                        'invoices.email',
                                        'invoices.id_tenant',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.nominal_bayar',
                                        'invoices.kembalian',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                        'invoices.created_at',
                                        'invoices.updated_at'
                                    ])
                                    ->with([
                                        'tenant' => function($query){
                                            $query->select([
                                                'tenants.id',
                                                'tenants.name'
                                            ]);
                                        },
                                        'storeMitra' => function($query){
                                            $query->select([
                                                'store_lists.id',
                                                'store_lists.id_user',
                                                'store_lists.email',
                                                'store_lists.store_identifier',
                                                'store_lists.name',
                                            ]);
                                        }
                                    ])
                                    ->whereHas('tenant', function($query){
                                        $query->where('id_inv_code', '==', 0);
                                    })
                                    ->latest()
                                    ->get();

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('nomor_invoice', function($data) {
                                    return $data->nomor_invoice;
                                })
                                ->editColumn('tenant', function($data) {
                                    return $data->tenant->name;
                                })
                                ->editColumn('store_identifier', function($data) {
                                    return $data->store_identifier;
                                })
                                ->editColumn('merchant_name', function($data) {
                                    return $data->storeMitra->name;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status_pembayaran == 1)?'<span class="badge bg-soft-success text-success">Selesai</span>':'<span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>');
                                })
                                ->editColumn('tanggal_transaksi', function($data) {
                                    // return $data->tanggal_transaksi;
                                    $date = \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->created_at)->format('H:i:s');
                                    $dateTimeTransaksi = $date." ".$time;
                                    return $dateTimeTransaksi;
                                })
                                ->editColumn('tanggal_pembayaran', function($data) {
                                    $date = \Carbon\Carbon::parse($data->tanggal_pelunasan)->format('d-m-Y');
                                    $time = \Carbon\Carbon::parse($data->updated_at)->format('H:i:s');
                                    $dateTimePembayaran = $date." ".$time;
                                    return $dateTimePembayaran;
                                })
                                ->editColumn('jenis_pembayaran', function($data) {
                                    return $data->jenis_pembayaran;
                                })
                                ->editColumn('nominal_bayar', function($data) {
                                    return $data->nominal_bayar;
                                })
                                ->editColumn('mdr', function($data) {
                                    return $data->mdr;
                                })
                                ->editColumn('nominal_mdr', function($data) {
                                    return $data->nominal_mdr;
                                })
                                ->editColumn('nominal_terima_bersih', function($data) {
                                    return $data->nominal_terima_bersih;
                                })
                                // ->editColumn('name', function($data) {
                                //     return $data->tenant->name;
                                // })
                                // ->addColumn('action', function($row){
                                //     $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                                //     return $actionBtn;
                                // })
                                ->rawColumns(['status'])
                                ->make(true);
        }
        // return view('testing');
    }
}
