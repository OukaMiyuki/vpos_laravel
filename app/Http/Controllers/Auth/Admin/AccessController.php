<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use App\Models\History;
use App\Models\Tenant;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Kasir;
use App\Models\AppVersion;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\APKLink;
use Illuminate\Support\Facades\App;

class AccessController extends Controller {
    public function adminDashboardAppVersion(){
        $appversion = AppVersion::find(1);
        $app = APKLink::find(1);
        return view('admin.admin_dashboard_application_appversion', compact('appversion', 'app'));
    }

    public function adminDashboardAppVersionUpdate(Request $request){
        $appversion = AppVersion::find(1);
        $appversion->update([
            'versi' => $request->versi
        ]);
        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.application.appversion')->with($notification);
    }

    public function adminDashboardAppUpdate(Request $request){
        $app = APKLink::find(1);

        if(!is_null($app->apk_link) || !empty($app->apk_link)){
            Storage::delete('public/apk/'.$app->apk_link);
        }

        $file = $request->file('app');
        $namaFile = $file->getClientOriginalName();
        $storagePath = Storage::path('public/apk');
        // $ext = $file->getClientOriginalExtension();
        // $filename = $namaFile.$ext;
        $file->move($storagePath, $namaFile);
        $pathFile = $storagePath.'/'.$namaFile;
        $size = \File::size($pathFile);
        if ($size >= 1073741824) {
            $size = number_format($size / 1073741824, 2) . ' GB';
        }
        elseif ($size >= 1048576) {
            $size = number_format($size / 1048576, 2) . ' MB';
        }
        elseif ($size >= 1024) {
            $size = number_format($size / 1024, 2) . ' KB';
        }
        elseif ($size > 1) {
            $size = $size . ' bytes';
        }
        elseif ($size == 1) {
            $size = $size . ' byte';
        }
        else {
            $size = '0 bytes';
        }
        $app->update([
            'file_size' => $size,
            'apk_link' => $namaFile
        ]);

        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.dashboard.application.appversion')->with($notification);
    }

    public function adminDashboardHistory(){
        return view('admin.admin_history_dashboard');
    }

    public function adminDashboardHistoryUserLogin(Request $request){
        if ($request->ajax()) {
            $activity = "Login";
            $data = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();

            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->where('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('activity', function($data) {
                                    return $data->action;
                                })
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('lokasi', function($data) {
                                    return $data->lokasi_anda;
                                })
                                ->editColumn('ip_address', function($data) {
                                    return $data->deteksi_ip;
                                })
                                ->editColumn('tanggal', function($data) {
                                    $date = \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                                    return $date;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status == 1)?'<span class="badge bg-soft-success text-success">Sukses</span>':'<span class="badge bg-soft-warning text-warning">Failed</span>');
                                })
                                ->editColumn('action', function($data) {
                                    $actionBtn = '';
                                    $activity = "Login";
                                    $id = $data->id;
                                    $actionBtn = '<a href="/admin/dashboard/history/detail/'.$activity.'/'.$id.'" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>';
                                    return $actionBtn;
                                })
                                ->rawColumns(['status', 'action'])
                                ->make(true);
        }
        return view('admin.admin_history_dashboard_user_login_history');
    }

    public function adminDashboardHistoryUserRegister(Request $request){
        if ($request->ajax()) {
            $activity = "Register";
            $data = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();

            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->where('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('activity', function($data) {
                                    return $data->action;
                                })
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('lokasi', function($data) {
                                    return $data->lokasi_anda;
                                })
                                ->editColumn('ip_address', function($data) {
                                    return $data->deteksi_ip;
                                })
                                ->editColumn('tanggal', function($data) {
                                    $date = \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                                    return $date;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status == 1)?'<span class="badge bg-soft-success text-success">Sukses</span>':'<span class="badge bg-soft-warning text-warning">Failed</span>');
                                })
                                ->editColumn('action', function($data) {
                                    $actionBtn = '';
                                    $activity = "Register";
                                    $id = $data->id;
                                    $actionBtn = '<a href="/admin/dashboard/history/detail/'.$activity.'/'.$id.'" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>';
                                    return $actionBtn;
                                })
                                ->rawColumns(['status', 'action'])
                                ->make(true);
        }
        return view('admin.admin_history_dashboard_user_register_history');
    }

    public function adminDashboardHistoryUserActivity(Request $request){
        if ($request->ajax()) {
            $activityRegister = "Register";
            $activityLogin = "Login";
            $activityWithdraw = "Withdraw";
            $data = History::where('action', 'NOT LIKE', '%'.$activityRegister.'%')
                                ->where('action', 'NOT LIKE', '%'.$activityLogin.'%')
                                ->where('action', 'NOT LIKE', '%'.$activityWithdraw.'%')
                                ->latest()
                                ->get();
            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->where('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('activity', function($data) {
                                    return $data->action;
                                })
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('lokasi', function($data) {
                                    return $data->lokasi_anda;
                                })
                                ->editColumn('ip_address', function($data) {
                                    return $data->deteksi_ip;
                                })
                                ->editColumn('tanggal', function($data) {
                                    $date = \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                                    return $date;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status == 1)?'<span class="badge bg-soft-success text-success">Sukses</span>':'<span class="badge bg-soft-warning text-warning">Failed</span>');
                                })
                                ->editColumn('action', function($data) {
                                    $actionBtn = '';
                                    $activity = "Register";
                                    $id = $data->id;
                                    $actionBtn = '<a href="/admin/dashboard/history/detail/'.$activity.'/'.$id.'" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>';
                                    return $actionBtn;
                                })
                                ->rawColumns(['status', 'action'])
                                ->make(true);
        }
        return view('admin.admin_history_dashboard_user_activity_history');
    }

    public function adminDashboardHistoryUserWithdrawal(Request $request){
        if ($request->ajax()) {
            $activity = "Withdraw";
            $data = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();

            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->where('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('activity', function($data) {
                                    return $data->action;
                                })
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('lokasi', function($data) {
                                    return $data->lokasi_anda;
                                })
                                ->editColumn('ip_address', function($data) {
                                    return $data->deteksi_ip;
                                })
                                ->editColumn('tanggal', function($data) {
                                    $date = \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                                    return $date;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status == 1)?'<span class="badge bg-soft-success text-success">Sukses</span>':'<span class="badge bg-soft-warning text-warning">Failed</span>');
                                })
                                ->editColumn('action', function($data) {
                                    $actionBtn = '';
                                    $activity = "Register";
                                    $id = $data->id;
                                    $actionBtn = '<a href="/admin/dashboard/history/detail/'.$activity.'/'.$id.'" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>';
                                    return $actionBtn;
                                })
                                ->rawColumns(['status', 'action'])
                                ->make(true);
        }
        return view('admin.admin_history_dashboard_user_withdraw_history');
    }

    public function adminDashboardHistoryUserError(Request $request){
        if ($request->ajax()) {
            $data = History::where('status', 0)->latest()->get();

            if($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->where('created_at', '>=', $request->from_date)->where('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('activity', function($data) {
                                    return $data->action;
                                })
                                ->editColumn('email', function($data) {
                                    return $data->email;
                                })
                                ->editColumn('lokasi', function($data) {
                                    return $data->lokasi_anda;
                                })
                                ->editColumn('ip_address', function($data) {
                                    return $data->deteksi_ip;
                                })
                                ->editColumn('tanggal', function($data) {
                                    $date = \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                                    return $date;
                                })
                                ->editColumn('status', function($data) {
                                    return (($data->status == 1)?'<span class="badge bg-soft-success text-success">Sukses</span>':'<span class="badge bg-soft-warning text-warning">Failed</span>');
                                })
                                ->editColumn('action', function($data) {
                                    $actionBtn = '';
                                    $activity = "Register";
                                    $id = $data->id;
                                    $actionBtn = '<a href="/admin/dashboard/history/detail/'.$activity.'/'.$id.'" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>';
                                    return $actionBtn;
                                })
                                ->rawColumns(['status', 'action'])
                                ->make(true);
        }
        return view('admin.admin_history_dashboard_user_error_history');
    }

    public function adminDashboardHistoryDetail($activity, $id){
        $user = "";
        $userType = "";
        $historyType = $activity;
        $history = History::find($id);

        if(is_null($history) || empty($history)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->route('admin.dashboard.history.user.detail')->with($notification);
        }

        $checkTenant = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email', 'tenants.id_inv_code'])->where('email', $history->email)->first();
        $checkAdmin = Admin::select(['admins.id', 'admins.name', 'admins.email', 'admins.access_level'])->where('email', $history->email)->first();
        $checkMarketing = Marketing::select(['marketings.id', 'marketings.name', 'marketings.email'])->where('email', $history->email)->first();
        $checkKasir = Kasir::select(['kasirs.id', 'kasirs.name', 'kasirs.email'])->where('email', $history->email)->first();

        if($checkTenant){
            $user = $checkTenant;
            if($user->id_inv_code == 0){
                $userType = "Mitra Bisnis";
            } else {
                $userType = "Tenant";
            }
        } else if($checkAdmin){
            $user = $checkAdmin;
            if($user->access_level == 0){
                $userType = "Super User";
            } else {
                $userType = "Administrator";
            }
        } else if($checkMarketing){
            $user = $checkMarketing;
            $userType = "Mitra Aplikasi";
        } else if($checkKasir){
            $user = $checkKasir;
            $userType = "Kasir";
        }

        return view('admin.admin_history_dashboard_user_history_detail', compact(['history', 'user', 'userType', 'historyType']));
    }
}
