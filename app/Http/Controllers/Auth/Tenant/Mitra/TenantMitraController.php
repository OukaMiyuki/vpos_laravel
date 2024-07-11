<?php

namespace App\Http\Controllers\Auth\Tenant\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\SendUmiEmail;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\StoreList;
use App\Models\UmiRequest;
use App\Models\QrisWallet;
use App\Models\TenantQrisAccount;
use App\Models\ApiKey;
use App\Models\CallbackApiData;
use App\Models\History;
use App\Models\SettlementHstory;
use File;
use Mail;
use Exception;

class TenantMitraController extends Controller {
    public function __construct() {
        $this->middleware('isTenantIsNotMitra');
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    private function createHistoryUser($action, $log, $status){
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

    public function index(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)
                        ->where('email', auth()->user()->email);
        $all = $invoice->count();
        $allToday = $invoice->whereDate('tanggal_transaksi', Carbon::now())->count();
        $allFinish = $invoice->whereDate('tanggal_transaksi', Carbon::now())->where('status_pembayaran', 1)->count();
        $invoiceNew = Invoice::with(['storeMitra'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->take(10)
                            ->get();
        return view('tenant.tenant_mitra.dashboard', compact(['all', 'allToday', 'allFinish', 'invoiceNew']));
    }

    public function storeDashboard(){
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store');
    }

    public function storeList(){
        $storeList = StoreList::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->withCount('invoice')
                                ->latest()
                                ->get();
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_list', compact(['storeList']));
    }

    public function storeCreate(){
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_create');
    }

    public function storeRegister(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diverifikasi dan diaktifkan oleh Admin!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        $action = "Mintra Bisnis : Merchant Register";
        DB::connection()->enableQueryLog();

        try{
            $randomString = Str::random(30);
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $request->name;
                $storagePath = Storage::path('public/images/profile/store_list');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    $this->createHistoryUser($action, $e, 0);
                }

                StoreList::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'store_identifier' => $randomString,
                    'name' => $request->name,
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'website' => $request->website,
                    'photo' => $filename,
                ]);
            } else {
                StoreList::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'store_identifier' => $randomString,
                    'name' => $request->name,
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'website' => $request->website,
                ]);
            }

            //$this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Toko berhasil ditambahkan!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        } catch(Exception $e){
            //$this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Gagal membuat data baru, harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

    }

    public function storeEdit($id){
        $store = StoreList::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->find($id);

        if(is_null($store) || empty($store)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_edit', compact('store'));
    }

    public function storeUpdate(Request $request){
        $action = "Mitra Bisnis : Merchant Update";
        DB::connection()->enableQueryLog();

        try{
            $tenantStore = StoreList::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->where('store_identifier', $request->store_identifier)
                                        ->find($request->id);

            if(is_null($tenantStore) || empty($tenantStore)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $request->nama;
                $storagePath = Storage::path('public/images/profile/store_list');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                if(empty($tenantStore->photo)){
                    try {
                        $file->move($storagePath, $filename);
                    } catch (\Exception $e) {
                        $this->createHistoryUser($action, $e, 0);
                    }
                } else {
                    try{
                        Storage::delete('public/images/profile/store_list/'.$tenantStore->photo);
                        $file->move($storagePath, $filename);
                    } catch(Exception $e){
                        $this->createHistoryUser($action, $e, 0);
                    }
                }

                $tenantStore->update([
                    'name' => $request->name,
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'website' => $request->website,
                    'photo' => $filename,
                ]);
            } else {
                $tenantStore->update([
                    'name' => $request->name,
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'website' => $request->website,
                ]);
            }
            //$this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data Toko berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        } catch(Exception $e){
            //$this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Data gagal diupdate, harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function storeDetail($id, $store_identifier){
        $store = StoreList::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->where('store_identifier', $store_identifier)
                            ->find($id);
        $umiRequest = "";
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $store_identifier)
                                ->first();

        if(is_null($store) || empty($store)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }

        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_detail', compact('store', 'umiRequest'));

    }

    public function storeInvoiceList($store_identifier){
        $store = StoreList::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->where('store_identifier', $store_identifier)
                            ->select(['store_lists.store_identifier', 'store_lists.name'])
                            ->first();

        if(is_null($store) || empty($store)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih'
                                ])
                            ->with(['storeMitra' => function($query){
                                $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->where('store_identifier', $store_identifier)
                            ->latest()
                            ->get();
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_transaction_list', compact('invoice', 'store'));
    }

    public function umiRequestList(){
        $umiRequest = UmiRequest::with(['storeList'])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->latest()
                                    ->get();

        return view('tenant.tenant_mitra.tenant_umi_request_list', compact('umiRequest'));
    }

    public function qrisRequestAccount($store_identifier){
        $tenantQris = TenantQrisAccount::where('store_identifier', $store_identifier)->first();
        if(is_null($tenantQris) || empty($tenantQris)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        return view('tenant.tenant_mitra.tenant_qris_detail', compact('tenantQris')); 
    }

    public function transationDashboard(){
        $all = Invoice::where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->count();
        $allToday = Invoice::where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->whereDate('tanggal_transaksi', Carbon::now())
                            ->count();
        $allPending = Invoice::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('status_pembayaran', 0)
                                ->count();
        $allFinish = Invoice::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('status_pembayaran', 1)
                                ->count();

        $storeList = StoreList::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->select(['store_lists.id', 'store_lists.id_user', 'store_lists.store_identifier', 'store_lists.name'])
                                ->withCount(['invoice'])
                                ->get();

        return view('tenant.tenant_mitra.tenant_transaction_dashboard', compact(['all', 'allToday', 'allPending', 'allFinish', 'storeList']));
    }

    public function transationStore($store_identifier){
        $store_list = StoreList::select(['store_lists.id',
                                        'store_lists.store_identifier',
                                        'store_lists.name'
                                ])
                                ->with(['invoice' => function($query){
                                    $query->select([
                                        'invoices.id',
                                        'invoices.store_identifier',
                                        'invoices.id_tenant',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.nominal_bayar',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                        'invoices.created_at'
                                    ])->latest()->get();
                                }])->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $store_identifier)
                                ->first();
        return view('tenant.tenant_mitra.tenant_transaction_store', compact('store_list'));

    }

    public function transationAll(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                                ])
                        ->with(['storeMitra' => function($query){
                            $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                        }])
                        ->where('id_tenant', auth()->user()->id)
                        ->where('email', auth()->user()->email)
                        ->latest()
                        ->get();
        return view('tenant.tenant_mitra.tenant_transaction_list', compact('invoice'));
    }

    public function transationAllToday(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                                ])
                            ->with(['storeMitra' => function($query){
                                $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->whereDate('tanggal_transaksi', Carbon::now())
                            ->latest()
                            ->get();
        return view('tenant.tenant_mitra.tenant_transaction_list_today', compact('invoice'));
    }

    public function transationPending(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                                ])
                            ->with(['storeMitra' => function($query){
                                    $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('status_pembayaran', 0)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->get();
        return view('tenant.tenant_mitra.tenant_transaction_list_pending', compact('invoice'));
    }

    public function transationFinish(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                                ])
                            ->with(['storeMitra' => function($query){
                                    $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('status_pembayaran', 1)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->get();
        return view('tenant.tenant_mitra.tenant_transaction_list_finish', compact('invoice'));
    }

    public function transationFinishToday(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at',
                                ])
                            ->with(['storeMitra' => function($query){
                                    $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->whereDate('tanggal_transaksi', Carbon::now())
                            ->where('status_pembayaran', 1)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->get();
            return view('tenant.tenant_mitra.tenant_transaction_list_finish_today', compact('invoice'));
    }

    public function appDashboard(){
        return view('tenant.tenant_mitra.tenant_application_dashboard');
    }

    public function qrisAccountList(){
        $qrisAcc = TenantQrisAccount::where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->with(['storeList'])
                                    ->latest()
                                    ->get();

        return view('tenant.tenant_mitra.tenant_application_qris', compact(['qrisAcc']));
    }

    public function qrisApiSetting(){
        $apiKey = ApiKey::where('id_tenant', auth()->user()->id)
                        ->where('email', auth()->user()->email)
                        ->first();
        $callback = CallbackApiData::where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        return view('tenant.tenant_mitra.tenant_application_settings', compact(['apiKey', 'callback']));

    }

    public function qrisApiSettingGenerateKey(){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diverifikasi dan diaktifkan oleh Admin!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $action = "Mitra Bisnis : Generate API Key";
        DB::connection()->enableQueryLog();

        $apiKey = ApiKey::where('id_tenant', auth()->user()->id)
                        ->where('email', auth()->user()->email)
                        ->first();

        try{
            $randomString = Str::random(150);
            if(is_null($apiKey) || empty($apiKey)){
                ApiKey::create([
                    'id_tenant' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'true_key' => $randomString,
                    'key' => Hash::make($randomString)
                ]);
            } else {
                $apiKey->update([
                    'true_key' => $randomString,
                    'key' => Hash::make($randomString)
                ]);
            }

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Key generated successfully!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Gagal membuat API Key, Harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function qrisApiSettingUpdateCallback(Request $request){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diverifikasi dan diaktifkan oleh Admin!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $action = "Mitra Bisnis : Callback API Settings Update";
        DB::connection()->enableQueryLog();

        $callback = CallbackApiData::where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();

        try{
            if(is_null($callback) || empty($callback)){
                CallbackApiData::create([
                    'id_tenant' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'callback' => $request->callback,
                    'parameter' => $request->parameter,
                    'secret_key_parameter' => $request->secret_key_parameter,
                    'secret_key' => $request->secret_key
                ]);
            } else {
                $callback->update([
                    'callback' => $request->callback,
                    'parameter' => $request->parameter,
                    'secret_key_parameter' => $request->secret_key_parameter,
                    'secret_key' => $request->secret_key
                ]);
            }

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Callback successfully updated!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Callback Error, harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function financeDashboard(){
        return view('tenant.tenant_mitra.tenant_finance_dashboard');
    }

    public function saldoData(){
        $qris = QrisWallet::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $qrisPending = Invoice::whereDate('tanggal_transaksi', '!=', Carbon::now())
                                ->where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('settlement_status', 0)
                                ->where('jenis_pembayaran', 'Qris')
                                ->where('status_pembayaran', 1)
                                ->sum('nominal_terima_bersih');
        $qrisHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::now())
                                ->where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('jenis_pembayaran', 'Qris')
                                ->where('status_pembayaran', 1)
                                ->sum('nominal_terima_bersih');
        $invoiceQrisSukses = Invoice::select(['invoices.id',
                                            'invoices.store_identifier',
                                            'invoices.id_tenant',
                                            'invoices.nomor_invoice',
                                            'invoices.tanggal_transaksi',
                                            'invoices.tanggal_pelunasan',
                                            'invoices.jenis_pembayaran',
                                            'invoices.status_pembayaran',
                                            'invoices.nominal_bayar',
                                            'invoices.mdr',
                                            'invoices.nominal_mdr',
                                            'invoices.nominal_terima_bersih',
                                            'invoices.created_at',
                                            'invoices.updated_at'
                                    ])
                                    ->with(['storeMitra' => function($query){
                                        $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                                    }])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->whereDate('tanggal_transaksi', Carbon::now())
                                    ->where('status_pembayaran', 1)
                                    ->where('email', auth()->user()->email)
                                    ->latest()
                                    ->get();

        return view('tenant.tenant_mitra.tenant_finance_saldo', compact(['qris', 'qrisPending', 'qrisHariIni', 'invoiceQrisSukses']));
    }

    public function settlementMitra(){
        $SettlementHstory = SettlementHstory::select([
                                                    'settlement_hstories.id',
                                                    'settlement_hstories.id_user',
                                                    'settlement_hstories.id_settlement',
                                                    'settlement_hstories.settlement_time_stamp',
                                                    'settlement_hstories.nominal_settle',
                                                    'settlement_hstories.status',
                                                    'settlement_hstories.note',
                                                ])
                                                ->with([
                                                    'settlement' => function($query){
                                                        $query->select([
                                                            'settlements.id',
                                                            'settlements.nomor_settlement'
                                                        ]);
                                                    }
                                                ])
                                                ->where('id_user', auth()->user()->id)
                                                ->where('email', auth()->user()->email)
                                                ->where('nominal_settle', '!=', 0)
                                                ->latest()
                                                ->get();
        return view('tenant.tenant_mitra.tenant_finance_settlement', compact('SettlementHstory'));
    }

    public function pemasukanQrisPending(){
        $invoice = Invoice::select(['invoices.id',
                                            'invoices.store_identifier',
                                            'invoices.id_tenant',
                                            'invoices.nomor_invoice',
                                            'invoices.tanggal_transaksi',
                                            'invoices.tanggal_pelunasan',
                                            'invoices.jenis_pembayaran',
                                            'invoices.status_pembayaran',
                                            'invoices.nominal_bayar',
                                            'invoices.mdr',
                                            'invoices.nominal_mdr',
                                            'invoices.nominal_terima_bersih',
                                            'invoices.created_at',
                                            'invoices.updated_at'
                                    ])
                                    ->with(['storeMitra' => function($query){
                                        $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                                    }])
                                    ->whereDate('tanggal_transaksi', Carbon::yesterday())
                                    ->where('status_pembayaran', 1)
                                    ->where('invoices.jenis_pembayaran', 'Qris')
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_mitra.tenant_finnance_pemasukan_qris_pending', compact('invoice'));
    }

    public function pemasukanQrisToday(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                            ])
                            ->with(['storeMitra' => function($query){
                                $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->whereDate('tanggal_transaksi', Carbon::now())
                            ->where('status_pembayaran', 1)
                            ->where('invoices.jenis_pembayaran', 'Qris')
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->get();
        return view('tenant.tenant_mitra.tenant_finnance_pemasukan_qris_today', compact('invoice'));
    }

    public function pemasukanQris(){
        $invoice = Invoice::select(['invoices.id',
                                    'invoices.store_identifier',
                                    'invoices.id_tenant',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.nominal_bayar',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                    'invoices.created_at',
                                    'invoices.updated_at'
                            ])
                            ->with(['storeMitra' => function($query){
                                $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('status_pembayaran', 1)
                            ->where('invoices.jenis_pembayaran', 'Qris')
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->latest()
                            ->get();

        $totalPemasukanQris = Invoice::where('invoices.jenis_pembayaran', 'Qris')
                                        ->where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->where('status_pembayaran', 1)
                                        ->sum(DB::raw('nominal_terima_bersih'));

        $totalPemasukanQrisHariini = Invoice::where('invoices.jenis_pembayaran', 'Qris')
                                                ->where('id_tenant', auth()->user()->id)
                                                ->where('email', auth()->user()->email)
                                                ->where('status_pembayaran', 1)
                                                ->whereDate('tanggal_transaksi', Carbon::today())
                                                ->sum('nominal_terima_bersih');

        $totalPemasukanQrisBulanIni = Invoice::where('invoices.jenis_pembayaran', 'Qris')
                                                ->where('id_tenant', auth()->user()->id)
                                                ->where('email', auth()->user()->email)
                                                ->where('status_pembayaran', 1)
                                                ->whereMonth('tanggal_transaksi', Carbon::now()->month)
                                                ->sum('nominal_terima_bersih');

        return view('tenant.tenant_mitra.tenant_finnance_pemasukan_qris', compact(['invoice', 'totalPemasukanQris', 'totalPemasukanQrisHariini', 'totalPemasukanQrisBulanIni']));
    }
}
