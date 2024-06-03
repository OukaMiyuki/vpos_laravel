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

    public function adminMenuUserTenantQris(){
        $tenantQris = TenantQrisAccount::latest()->get();
        return view('admin.admin_menu_dashboard_user_tenant_qris', compact(['tenantQris']));
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
        // $invitationCode = InvitationCode::count();
        $marketingData = Marketing::with('detail')->where('is_active', 1)->latest()->take(5)->get();
        $marketingAktivasi = Marketing::where('is_active', 0)->latest()->take(10)->get();
        return view('admin.admin_marketing_dashboard', compact('marketingList', 'marketingData', 'marketingAktivasi'));
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
        $marketing = Marketing::find($id);
        return view('admin.admin_marketing_profile', compact('marketing'));
    }

    public function adminMarketingAccountUpdate(Request $request){
        $marketing = Marketing::find($request->id);

        $marketing->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->status,
        ]);

        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function adminMarketingAccountInfoUpdate(Request $request){
        $detailMarketing = DetailMarketing::find($request->id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = $detailMarketing->name;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($detailMarketing->detail->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/profile/'.$detailMarketing->detail->photo);
                $file->move($storagePath, $filename);
            }

            $detailMarketing->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'photo' => $filename,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } else {
            $detailMarketing->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }
}
