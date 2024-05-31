<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Marketing;
use App\Models\DetailMarketing;
use App\Models\Tenant;
use App\Models\Withdrawal;
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
                                    ->take(10)
                                    ->get();
        $totalWithdrawToday = 0;
        foreach($withDrawToday as $wd){
            $totalWithdrawToday+=$wd->detail_withdraw_sum_biaya_admin_su;
        }

        $withdrawCount = $withdrawals->count();
        $withdrawNew = $withdrawals->select([
                                'withdrawals.id',
                                'withdrawals.email',
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
                            ->take(10)
                            ->latest()
                            ->get();
        dd($withdrawNew);
        return view('admin.dashboard', compact(['marketingCount', 'mitraBisnis', 'mitraTenant', 'withdrawCount', 'totalWithdrawToday', 'marketing', 'withdrawNew']));
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
