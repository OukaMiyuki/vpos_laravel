<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $path = Storage::path('public/apk/'.$apk->apk_link);
        return response()->download($path);
    }
}
