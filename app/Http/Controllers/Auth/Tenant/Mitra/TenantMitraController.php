<?php

namespace App\Http\Controllers\Auth\Tenant\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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
use File;
use Mail;
use Exception;

class TenantMitraController extends Controller {
    public function __construct() {
        $this->middleware('isTenantIsNotMitra');
    }

    public function index(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)
                        ->where('email', auth()->user()->email);
        $all = $invoice->count();
        $allToday = $invoice->whereDate('tanggal_transaksi', Carbon::now())->count();
        $allFinish = $invoice->whereDate('tanggal_transaksi', Carbon::now())->where('status_pembayaran', 1)->count();
        $invoiceNew = Invoice::where('id_tenant', auth()->user()->id)
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
                                ->latest()
                                ->get();
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_list', compact(['storeList']));
    }

    public function storeCreate(){
        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_create');
    }

    public function storeRegister(Request $request){
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
                return $e->getMessage();
            }

            StoreList::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'store_identifier' => $randomString,
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'kode_pos' => $request->kode_pos,
                'no_telp_toko' => $request->no_telp,
                'jenis_usaha' => $request->jenis,
                'photo' => $filename
            ]);
        } else {
            StoreList::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'store_identifier' => $randomString,
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'kode_pos' => $request->kode_pos,
                'no_telp_toko' => $request->no_telp,
                'jenis_usaha' => $request->jenis,
            ]);
        }

        $notification = array(
            'message' => 'Toko berhasil ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);

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
                        return $e->getMessage();
                    }
                } else {
                    Storage::delete('public/images/profile/store_list/'.$tenantStore->photo);
                    $file->move($storagePath, $filename);
                }

                $tenantStore->update([
                    'name' => $request->name,
                    'alamat' => $request->alamat,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'photo' => $filename
                ]);
            } else {
                $tenantStore->update([
                    'name' => $request->name,
                    'alamat' => $request->alamat,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                ]);
            }

            $notification = array(
                'message' => 'Data Toko berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        } catch(Exception $e){
            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function storeDetail($id, $store_identifier){
        $store = StoreList::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->find($id);
        $umiRequest = "";
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $store_identifier)
                                ->first();
        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }

        if(is_null($store) || empty($store)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.list')->with($notification);
        }

        return view('tenant.tenant_mitra.tenant_mitra_dashboard_store_detail', compact('store', 'umiRequest'));

    }

    public function requestUmi(Request $request){
        $store_id = $request->id;
        $store_identifier = $request->store_identifier;

        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $store_identifier)
                                ->first();
        $tenant = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email', 'tenants.phone', 'tenants.is_active', 'tenants.phone_number_verified_at', 'tenants.email_verified_at'])
                                ->with(['detail' => function($query){
                                    $query->select(['detail_tenants.id', 
                                                    'detail_tenants.id_tenant', 
                                                    'detail_tenants.no_ktp',
                                                    'detail_tenants.tempat_lahir',
                                                    'detail_tenants.tanggal_lahir',
                                                    'detail_tenants.jenis_kelamin',
                                                    'detail_tenants.alamat',
                                                    'detail_tenants.photo'])
                                            ->where('detail_tenants.id_tenant', auth()->user()->id)
                                            ->where('detail_tenants.email', auth()->user()->email)
                                            ->first();
                                }
                                ])
                                ->find(auth()->user()->id);
        $store = StoreList::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->where('store_identifier',  $store_identifier)
                            ->find($store_id);

        if(empty($umiRequest) || is_null($umiRequest) || $umiRequest == ""){
            $tanggal = date("j F Y", strtotime(date('Y-m-d')));
            $nama_pemilik = $tenant->name;
            $no_ktp = $tenant->no_ktp;
            $no_hp = $tenant->phone;
            $email = $tenant->email;
            $nama_usaha = $store->name;
            $jenis_usaha = $store->jenis_usaha;
            $alamat = $store->alamat;
            $kab_kota = $store->kab_kota;
            $kode_pos = $store->kode_pos;
            $templatePath = Storage::path('public/docs/umi/template/Formulir_Pendaftaran_NOBU_QRIS_(NMID).xlsx');
            $userDocsPath = Storage::path('public/docs/umi/user_doc');
            $filename = 'Formulir Pendaftaran NOBU QRIS (NMID) PT BRAHMA ESATAMA_'.$nama_usaha.'_'.date('dmYHis').'.xlsx';
            $fileSave = $userDocsPath.'/'.$filename;
            try {
                File::copy($templatePath, $fileSave);
                $spreadsheet = IOFactory::load($fileSave);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('D6', $tanggal);
                $sheet->setCellValue('C10', $nama_pemilik);
                $sheet->setCellValue('D10', $no_ktp);
                $sheet->setCellValue('E10', $no_hp);
                $sheet->setCellValue('F10', $email);
                $sheet->setCellValue('G10', $nama_usaha);
                $sheet->setCellValue('H10', $jenis_usaha);
                $sheet->setCellValue('I10', $alamat);
                $sheet->setCellValue('J10', $kab_kota);
                $sheet->setCellValue('K10', $kode_pos);
                $sheet->setCellValue('L10', 'Ya');
                $sheet->setCellValue('M10', 'UMI - Penjualan/Tahun: < 2M');
                $sheet->setCellValue('N10', 'Booth (Dinamis & Statis)');
                $sheet->setCellValue('O10', '0,00%');
                $sheet->setCellValue('P10', 'Ya');
                $sheet->setCellValue('Q10', '');
                $newFilePath = $fileSave;
                $writer = new Xlsx($spreadsheet);
                $writer->save($newFilePath);
                UmiRequest::create([
                    'id_tenant' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'store_identifier' => $store_identifier,
                    'tanggal_pengajuan' => Carbon::now(),
                    'file_path' => $filename
                ]);

                $mailData = [
                    'title' => 'Formulir Pendaftaran UMI',
                    'body' => 'This is for testing email using smtp.',
                    'file' => $fileSave
                ];
                 
                Mail::to('ouka.dev@gmail.com')->send(new SendUmiEmail($mailData, $store_identifier));
                   
                // dd("Email is sent successfully.");

                $notification = array(
                    'message' => 'Permintaan UMI berhasil diajukan!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch (Exception $e) {
                return $e;
                exit;
            }
        } else {
            return redirect()->back();
        }
    }

    public function umiRequestList(){
        $umiRequest = UmiRequest::with(['storeList'])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->latest()
                                    ->get();

        return view('tenant.tenant_mitra.tenant_umi_request_list', compact('umiRequest'));
    }

    public function transationDashboard(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email);
        $all = $invoice->count();
        $allToday = $invoice->whereDate('tanggal_transaksi', Carbon::now())->count();
        $allPending = $invoice->where('status_pembayaran', 0)->count();
        $allFinish = $invoice->where('status_pembayaran', 1)->count();

        $storeList = Invoice::select([
                                        'id',
                                        "store_identifier",
                                        DB::raw("(count(store_identifier)) as banyak_transaksi")
                                    ])
                                    ->with(['storeMitra' => function($query){
                                        $query->select([
                                            'store_lists.id',
                                            'store_lists.store_identifier',
                                            'store_lists.name'
                                        ]);
                                    }])
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->groupBy(['id','store_identifier'])
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
                                        'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
                                ])
                            ->with(['storeMitra' => function($query){
                            $query->select(['store_lists.id', 'store_lists.store_identifier','store_lists.name'])->get();
                            }])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
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
                                    'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
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

    public function financeDashboard(){
        return view('tenant.tenant_mitra.tenant_finance_dashboard');
    }

    public function saldoData(){
        $qris = QrisWallet::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $qrisPending = Invoice::whereDate('tanggal_transaksi', Carbon::yesterday())
                                ->where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
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
                                            'invoices.nominal_terima_bersih'
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
                                            'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
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
                                    'invoices.nominal_terima_bersih'
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
