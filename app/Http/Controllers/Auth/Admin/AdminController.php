<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
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

class AdminController extends Controller {
    // Teting github error
    public function index(){
        $marketingCount = Marketing::count();
        $mitraBisnis = Tenant::where('id_inv_code', '==', 0)->count();
        $mitraTenant = Tenant::where('id_inv_code', '!=', 0)->count();
        $withdrawals = Withdrawal::where('email', '!=' , auth()->user()->email);
        $withDrawToday = Withdrawal::where('email', '!=' , auth()->user()->email)
                                     ->whereDate('tanggal_penarikan', Carbon::now())
                                     ->where('status', 1)
                                     ->withSum('detailWithdraw', 'biaya_admin_su')
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
            $totalWithdrawToday+=$wd->detail_withdraw_sum_biaya_admin_su;
        }

        $withdrawCount = $withdrawals->count();
        $withdrawNew = $withdrawals->select([
                                'withdrawals.id',
                                'withdrawals.invoice_pemarikan',
                                'withdrawals.tanggal_penarikan',
                                'withdrawals.nominal',
                                'withdrawals.status',
                            ])
                            ->with(['detailWithdraw' => function($query){
                                $query->select([
                                    'detail_penarikans.id',
                                    'detail_penarikans.id_penarikan',
                                    'detail_penarikans.nominal_penarikan',
                                    'detail_penarikans.biaya_admin_su'
                                ]);
                            }])
                            ->take(5)
                            ->latest()
                            ->get();
        //dd($withdrawNew);
        return view('admin.dashboard', compact(['marketingCount', 'mitraBisnis', 'mitraTenant', 'withdrawCount', 'totalWithdrawToday', 'marketing', 'withdrawNew']));
    }

    public function adminMenuDashboard(){
        return view('admin.admin_menu_dashboard');
    }

    public function adminMenuUserTransaction(){
        $invoice = Invoice::latest()->get();
        return view('admin.admin_menu_dashboard_user_transaction', compact('invoice'));
    }

    public function adminMenuUserWithdrawals(){
        $withdrawals = Withdrawal::select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.email',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                ])
                                ->with(['detailWithdraw' => function($query){
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
                                }])
                                ->latest()
                                ->get();

        return view('admin.admin_menu_dashboard_user_withdrawals', compact(['withdrawals']));
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
                                    'umi_requests.note'
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
        $umiRequest = UmiRequest::where('store_identifier', $request->store_identifier)->find($request->id);

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

        $notification = array(
            'message' => 'Umi berhasil disetujui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserUmiRequestReject(Request $request){
        $umiRequest = UmiRequest::where('store_identifier', $request->store_identifier)->find($request->id);

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

        $notification = array(
            'message' => 'Akun Tenant Qris berhasil dibuat!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserTenantQrisUpdate(Request $request){
        $id = $request->id;
        $store_identifier = $request->store_identifier;
        $qris_login = $request->qris_login;
        $qris_password = $request->qris_password;
        $qris_merchant_id = $request->qris_merchant_id;
        $qris_store_id = $request->qris_store_id;
        $mdr = $request->mdr;
        $qris = TenantQrisAccount::where('store_identifier', $store_identifier)->find($id);

        $qris->update([
            'qris_login_user' => $qris_login,
            'qris_password' => $qris_password,
            'qris_merchant_id' => $qris_merchant_id,
            'qris_store_id' => $qris_store_id,
            'mdr' => $mdr
        ]);

        $notification = array(
            'message' => 'Akun Tenant Qris berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMenuUserTenantQrisDelete($id){
        $qris = TenantQrisAccount::find($id);

        if(is_null($qris) || empty($qris)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $qris->delete();
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

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if(!is_null($admin)) {
            $admin->detailAdminStore($admin);
        }

        $notification = array(
            'message' => 'Admin berhasil diregister!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.administrator.list')->with($notification);
    }

    public function adminActivation($id){
        $admin = Admin::find($id);

        if(is_null($admin) || empty($admin)){
            $notification = array(
                'message' => 'Data Admin tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.dashboard.administrator.list')->with($notification);
        }

        if($admin->is_active == 0){
            $admin->update([
                'is_active' => 1
            ]);
        } else {
            $admin->update([
                'is_active' => 0
            ]);
        }

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

        if($marketing->is_active == 0){
            $marketing->is_active = 1;
        } else if($marketing->is_active == 1){
            $marketing->is_active = 2;
        } else if($marketing->is_active == 2){
            $marketing->is_active = 1;
        }
        $marketing->save();
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
                                    'withdrawals.id_user',
                                    'withdrawals.email',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                ])
                                ->with(['detailWithdraw' => function($query){
                                    $query->select([
                                        'detail_penarikans.id',
                                        'detail_penarikans.id_penarikan',
                                        'detail_penarikans.nominal_penarikan',
                                        'detail_penarikans.nominal_bersih_penarikan',
                                        'detail_penarikans.biaya_nobu',
                                        'detail_penarikans.biaya_mitra',
                                        'detail_penarikans.biaya_tenant',
                                        'detail_penarikans.biaya_admin_su',
                                        'detail_penarikans.biaya_agregate',
                                    ]);
                                }])
                                ->latest()
                                ->get();
                            }])
                            ->latest()
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

    public function adminDashboardMitraBisnisMerchantList(){
        $storeList = StoreList::select([
                                'store_lists.id',
                                'store_lists.id_user',
                                'store_lists.email',
                                'store_lists.store_identifier',
                                'store_lists.name',
                                'store_lists.jenis_usaha',
                                'store_lists.status_umi',
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

    public function adminDashboardMitraBisnisTransactionList(){
        $tenantInvoice = Tenant::select(['tenants.id', 'tenants.name'])
                                ->where('id_inv_code', 0)
                                ->with([
                                    'storeList' => function($query){
                                        $query->select([
                                            'store_lists.id',
                                            'store_lists.id_user',
                                            'store_lists.email',
                                            'store_lists.store_identifier',
                                            'store_lists.name',
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
                                                ])
                                                ->latest()
                                                ->get();
                                            }
                                        ]);
                                    }
                                ])
                                ->latest()
                                ->get();
        return view('admin.admin_mitra_bisnis_transaction_list', compact('tenantInvoice'));
    }

    public function adminDashboardMitraBisnisWithdrawalList(){
        $tenantWithdraw = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email'])
                        ->with([
                            'withdrawal' => function($query){
                                $query->select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.id_user',
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
                                            'detail_penarikans.nominal_penarikan',
                                            'detail_penarikans.nominal_bersih_penarikan',
                                            'detail_penarikans.total_biaya_admin',
                                            'detail_penarikans.biaya_nobu',
                                            'detail_penarikans.biaya_mitra',
                                            'detail_penarikans.biaya_tenant',
                                            'detail_penarikans.biaya_admin_su',
                                            'detail_penarikans.biaya_agregate',
                                        ]);
                                    }
                                ])
                                ->latest()
                                ->get();    
                            }
                        ])
                        ->where('id_inv_code', 0)
                        ->latest()
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
                                            'tenants.name'
                                        ]);
                                    }
                                ])
                                ->withCount(['invoice'])
                                ->latest()
                                ->get();
        return view('admin.admin_mitra_tenant_store_list', compact(['storeDetail']));
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
}
