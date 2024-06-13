<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreDetail;

class IsKasirStoreActive {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $storeDetail = StoreDetail::select([
                                    'store_details.id',
                                    'store_details.store_identifier',
                                    'store_details.id_tenant',
                                ])
                                ->with([
                                    'tenant' => function($query){
                                        $query->select([
                                            'tenants.id',
                                            'tenants.is_active'
                                        ]);
                                    }
                                ])
                                ->where('store_identifier', auth()->user()->id_store)
                                ->first();

        if(is_null($storeDetail) || empty($storeDetail)){
            Auth::guard('kasir')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array(
                'message' => 'Tenant tidak ditemukan!',
                'alert-type' => 'error',
            );
            return redirect()->route('access.login')->with($notification);
        } else {
            if($storeDetail->tenant->is_active == 2){
                Auth::guard('kasir')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $notification = array(
                    'message' => 'Login gagal, toko telah dinonaktifkan oleh admin!',
                    'alert-type' => 'error',
                );
                return redirect()->route('access.login')->with($notification);
            }
        }
        return $next($request);
    }
}
