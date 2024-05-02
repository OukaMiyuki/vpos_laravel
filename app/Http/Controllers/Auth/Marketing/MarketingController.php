<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\InvitationCode;
use App\Models\Marketing;
use App\Models\Tenant;

class MarketingController extends Controller {
    public function index(){
        $code = InvitationCode::where('id_marketing', auth()->user()->id)->count();
        $tenant = Marketing::select(['id'])
                            ->withCount('invitationCodeTenant')
                            ->where('id', auth()->user()->id)
                            ->get();
        $tenantTerbaru = Marketing::select(['marketings.id'])
                                    ->with(['invitationCodeTenant' => function($query){
                                        $query->select('tenants.id', 'tenants.name', 'tenants.phone', 'tenants.is_active', 'tenants.id_inv_code')
                                                ->with(['invitationCode' => function($query) {
                                                    $query->select('invitation_codes.id', 'invitation_codes.inv_code', 'invitation_codes.holder')->get();
                                                }])->get();
                                    }])
                                    ->where('id', auth()->user()->id)
                                    ->latest()
                                    ->limit(5)
                                    ->get();
        // $daftarTenantBaru = $tenantTerbaru->toArray();
        // dd($daftarTenantBaru);
        //dd($tenantTerbaru);
        $tenantNumber = "";
        foreach($tenant as $t){
            $tenantNumber = $t->invitation_code_tenant_count;
        }
        return view('marketing.dashboard', compact('code', 'tenantNumber', 'tenantTerbaru'));
    }

    public function invitationCodeDashboard(){
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
    }

    public function invitationCodeInsert(Request $request){
        $inv_code = Str::upper($request->code);
        InvitationCode::create([
            'id_marketing' => auth()->user()->id,
            'holder' => $request->holder,
            'inv_code' => $inv_code
        ]);

        $notification = array(
            'message' => 'Kode telah dibuat!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function invitationCodeCashoutList(){
        return view('marketing.marketing_invitation_code_data_penarikan');
    }

    public function invitationCodeCashoutInvoice(){
        return view('marketing.marketing_invitation_code_invoice');
    }

    public function marketingTenantList(){
        $tenant = Marketing::select(['id'])->where('id', auth()->user()->id)
                        ->with(['invitationCodeTenant' => function ($query) {
                            $query->with(['invitationCode'])->select(['tenants.id as id_tenant', 'name', 'phone', 'id_inv_code', 'tenants.created_at as tanggal_bergabung']);
                        }
                    ])->get();
        // $tenant = Marketing::select(['id'])->with(['tenantList'])->where('id', auth()->user()->id)->get();
        // dd($tenant);
        return view('marketing.marketing_tenant_list', compact('tenant'));
    }

    public function marketingTenantDetail($inv_code, $id,){
        $tenant = Tenant::select(['id', 'name', 'email', 'phone', 'is_active'])
                        ->with(['detail', 'storeDetail'])
                        ->where('id_inv_code', $inv_code)
                        ->where(DB::table('invitation_codes')
                            ->where('inv_code', $inv_code)
                            ->where('id_marketing', auth()->user()->id)
                            ->first()
                        )
                        ->find($id);
        // dd($tenant);
        return view('marketing.marketing_tenant_detail', compact('tenant'));
    }
}
