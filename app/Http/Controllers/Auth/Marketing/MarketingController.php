<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InvitationCode;
use App\Models\Marketing;
use App\Models\Tenant;

class MarketingController extends Controller {
    public function index(){
        $code = InvitationCode::where('id_marketing', auth()->user()->id)->count();
        // $tenant = Marketing::with('invitationCodeTenant')->where('id', auth()->user()->id)->get();
        $tenant = Marketing::select(['id'])
                            ->withCount('invitationCodeTenant')
                            // ->whereHas('invitationCodeTenant.InvitationCode')
                            ->where('id', auth()->user()->id)
                            ->get();
        // $countTenant = $tenant->invitationCodeTenant->tenant->count();
        // dd($tenant);
        $tenantNumber = "";
        foreach($tenant as $t){
            $tenantNumber = $t->invitation_code_tenant_count;
        }
        return view('marketing.dashboard', compact('code', 'tenantNumber'));
    }

    public function invitationCodeList(){
        $invitationCode = InvitationCode::where('id_marketing', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('marketing.marketing_invitation_code_list', compact('invitationCode'));
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
                            $query->with(['invitationCode'])->select(['tenants.id as id_tenant', 'name', 'email', 'phone', 'id_inv_code']);
                        }
                    ])->get();
        // $tenant = Marketing::select(['id'])->with(['tenantList'])->where('id', auth()->user()->id)->get();
        // dd($tenant);
        return view('marketing.marketing_tenant_list', compact('tenant'));
    }

    public function marketingTenantDetail($inv_code, $id,){
        $tenant = Tenant::with(['detail', 'storeDetail'])
                        ->where('id_inv_code', $inv_code)
                        ->find($id);
        dd($tenant);
    }
}
