<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\APKLink;

class HomeController extends Controller {
    public function index(){
        if(auth()->check()){
            return "walla";
        }
        return view('welcome');
    }

    public function downloadApk(){
        $apk = APKLink::find(1);
        return response()->download($apk->apk_link);
    }
}
