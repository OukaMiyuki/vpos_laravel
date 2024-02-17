<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InvitationCode;

class MarketingController extends Controller {
    public function index(){
        return view('marketing.dashboard');
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
}
