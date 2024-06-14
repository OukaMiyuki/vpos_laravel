<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Tenant;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Kasir;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AccessController extends Controller {
    public function adminDashboardHistory(){
        return view('admin.admin_history_dashboard');
    }

    public function adminDashboardHistoryUserLogin(){
        $activity = "Login";
        $history = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();
        return view('admin.admin_history_dashboard_user_login_history', compact(['history']));
    }

    public function adminDashboardHistoryUserRegister(){
        $activity = "Register";
        $history = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();
        return view('admin.admin_history_dashboard_user_register_history', compact(['history']));
    }

    public function adminDashboardHistoryUserActivity(){
        $activityRegister = "Register";
        $activityLogin = "Login";
        $activityWithdraw = "Withdraw";
        $history = History::where('action', 'NOT LIKE', '%'.$activityRegister.'%')
                            ->where('action', 'NOT LIKE', '%'.$activityLogin.'%')
                            ->where('action', 'NOT LIKE', '%'.$activityWithdraw.'%')
                            ->latest()
                            ->get();
        return view('admin.admin_history_dashboard_user_activity_history', compact(['history']));
    }

    public function adminDashboardHistoryUserWithdrawal(){
        $activity = "Withdraw";
        $history = History::where('action', 'LIKE', '%'.$activity.'%')->latest()->get();
        return view('admin.admin_history_dashboard_user_withdraw_history', compact(['history']));
    }

    public function adminDashboardHistoryUserError(){
        $history = History::where('status', 0)->latest()->get();
        return view('admin.admin_history_dashboard_user_error_history', compact(['history']));
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
