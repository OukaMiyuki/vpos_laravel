<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Mail\SendUmiEmail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UmiRequest;
use App\Models\Tenant;
use App\Models\StoreList;
use App\Models\History;
use File;
use Mail;
use Exception;

class UmiController extends Controller {
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

    public function umiRequestForm(){
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }
        return view('tenant.tenant_umi_request', compact('umiRequest'));
    }

    public function umiRequestProcess(Request $request){
        $action = "Tenant : Store UMI Request";
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $request->store_identifier)
                                ->first();
        if(empty($umiRequest) || is_null($umiRequest) || $umiRequest == ""){
            $tanggal = date("j F Y", strtotime(date('Y-m-d')));
            $store_identifier = $request->store_identifier;
            $nama_pemilik = $request->nama_pemilik;
            $no_ktp = $request->no_ktp;
            $no_hp = $request->no_hp;
            $email = $request->email;
            $nama_usaha = $request->nama_usaha;
            $jenis_usaha = $request->jenis_usaha;
            $alamat = $request->alamat;
            $nama_jalan = $request->nama_jalan;
            $nama_blok = $request->nama_blok;
            $rt = $request->rt;
            $rw = $request->rw;
            $kelurahan_desa = $request->kelurahan_desa;
            $kecamatan = $request->kecamatan;
            $kab_kota = $request->kabupaten;
            $kode_pos = $request->kode_pos;
            $no_npwp = $request->no_npwp;
            $kantor_toko_fisik = $request->kantor_toko_fisik;
            $kategori_usaha_omset = $request->kategori_usaha_omset;
            $website = $request->website;

            if(empty($nama_usaha)
                || is_null($nama_usaha)
                || $nama_usaha == ""
                || empty($jenis_usaha)
                || is_null($jenis_usaha)
                || $jenis_usaha == ""
                || empty($alamat)
                || is_null($alamat)
                || $alamat == ""
                || empty($kab_kota)
                || is_null($kab_kota)
                || $kab_kota == ""
                || empty($kode_pos)
                || is_null($kode_pos)
                || $kode_pos == ""
                || is_null($nama_jalan)
                || is_null($rt)
                || is_null($rw)
                || is_null($kelurahan_desa)
                || is_null($kecamatan)
                || is_null($kantor_toko_fisik)
                || is_null($kategori_usaha_omset)
                || is_null(auth()->user()->detail->ktp_image)
            ) {
                $notification = array(
                    'message' => 'Data detail toko belum lengkap, silahkan lengkapi data terlebih dahulu!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
            $imageKTPPath = Storage::path('public/images/profile/'.auth()->user()->detail->ktp_image);
            $templatePath = Storage::path('public/docs/umi/template/Formulir_Pendaftaran_QRIS_Nobu_(NMID_Level).xlsx');
            $userDocsPath = Storage::path('public/docs/umi/user_doc');
            $filename = 'Formulir Pendaftaran NOBU QRIS (NMID) PT BRAHMA ESATAMA_'.$nama_usaha.'_'.date('dmYHis').'.xlsx';
            $fileSave = $userDocsPath.'/'.$filename;
            try {
                File::copy($templatePath, $fileSave);
                $spreadsheet = IOFactory::load($fileSave);
                // $sheet = $spreadsheet->getActiveSheet();
                $sheet1 = $spreadsheet->getSheet(0);
                $sheet1->mergeCells('E6:F6');
                $sheet1->getCell('E6')->setValue($nama_usaha);
                $sheet1->mergeCells('E7:F7');
                $sheet1->getCell('E7')->setValue($nama_usaha);
                $sheet1->mergeCells('E9:F9');
                $sheet1->getCell('E9')->setValue($no_npwp);
                $sheet1->mergeCells('E10:F10');
                $sheet1->getCell('E10')->setValue($alamat);
                $sheet1->mergeCells('E11:F11');
                $sheet1->getCell('E11')->setValue($nama_pemilik);
                $sheet1->mergeCells('E12:F12');
                $sheet1->getCell('E12')->setValue($no_hp);
                $sheet1->mergeCells('E13:F13');
                $sheet1->getCell('E13')->setValue($email);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('no_ktp');
                $drawing->setDescription('No KTP Pemilik Usaha');
                $drawing->setPath($imageKTPPath);
                $drawing->setCoordinates('H6');
                // $drawing->setOffsetX(110);
                $drawing->getShadow()->setVisible(true);
                $drawing->getShadow()->setDirection(45);
                $drawing->setWorksheet($sheet1);

                $sheet2 = $spreadsheet->getSheet(1);
                $sheet2->mergeCells('D4:E4');
                $sheet2->getCell('D4')->setValue($nama_usaha);
                $sheet2->mergeCells('D5:E5');
                $sheet2->getCell('D5')->setValue($nama_pemilik);
                $sheet2->mergeCells('D6:E6');
                $sheet2->getCell('D6')->setValue($tanggal);
                $sheet2->getCell('C11')->setValue($nama_pemilik);
                $sheet2->getCell('D11')->setValue($no_ktp);
                $sheet2->getCell('E11')->setValue($no_hp);
                $sheet2->getCell('F11')->setValue($email);
                $sheet2->getCell('G11')->setValue($nama_usaha);
                $sheet2->getCell('H11')->setValue($jenis_usaha);
                $sheet2->getCell('I11')->setValue($nama_jalan);
                $sheet2->getCell('J11')->setValue($nama_blok);
                $sheet2->getCell('K11')->setValue($rt);
                $sheet2->getCell('L11')->setValue($rw);
                $sheet2->getCell('M11')->setValue($kelurahan_desa);
                $sheet2->getCell('N11')->setValue($kecamatan);
                $sheet2->getCell('O11')->setValue($kab_kota);
                $sheet2->getCell('P11')->setValue($kode_pos);
                $sheet2->getCell('Q11')->setValue($kantor_toko_fisik);
                $sheet2->getCell('R11')->setValue($kategori_usaha_omset);
                $sheet2->getCell('V11')->setValue($website);   

                $newFilePath = $fileSave;
                $writer = new Xlsx($spreadsheet);
                $writer->save($newFilePath);
                UmiRequest::create([
                    'id_tenant' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'store_identifier' => $store_identifier,
                    'tanggal_pengajuan' => Carbon::now(),
                    'file_path' => $filename,
                ]);

                $mailData = [
                    'title' => 'Formulir Pendaftaran UMI',
                    'body' => 'This is for testing email using smtp.',
                    'file' => $fileSave,
                    'storeName' => $nama_usaha,
                    'jenisUsaha' => $jenis_usaha,
                    'alamat' => $alamat,
                    'kabupaten' => $kab_kota,
                    'kodePos' => $kode_pos
                ];

                try{
                    Mail::to('ouka.dev@gmail.com')->send(new SendUmiEmail($mailData, $request->store_identifier));
                } catch(Exception $e){
                    return $e;
                }

                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

                $notification = array(
                    'message' => 'Permintaan UMI berhasil diajukan!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch (Exception $e) {
                $this->createHistoryUser($action, $e, 0);
                $notification = array(
                    'message' => 'Permintaan UMI gagal, silahkan hubungi admin!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        } else {
            return redirect()->back();
        }
    }

    public function requestUmiMitra(Request $request){
        if(auth()->user()->is_active == 0){
            $notification = array(
                'message' => 'Akun anda belum diverifikasi dan diaktifkan oleh Admin!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $action = "Mitra Bisnis : Request UMI";
        DB::connection()->enableQueryLog();
        $store_id = $request->id;
        $store_identifier = $request->store_identifier;
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->route('tenant.mitra.dashboard.toko.detail')->with($notification);
        }

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
                                                    'detail_tenants.photo',
                                                    'detail_tenants.nama_perusahaan',
                                                    'detail_tenants.ktp_image'])
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

            $store_identifier = $store->store_identifier;
            $nama_pemilik = $tenant->name;
            $no_ktp = $tenant->detail->no_ktp;
            $ktp_image = $tenant->detail->ktp_image;
            $nama_perusahaan = $tenant->detail->nama_perusahaan;
            $no_hp = $tenant->phone;
            $email = $tenant->email;
            $nama_usaha = $store->name;
            $jenis_usaha = $store->jenis_usaha;
            $alamat = $store->alamat;
            $nama_jalan = $store->nama_jalan;
            $nama_blok = $store->nama_blok;
            $rt = $store->rt;
            $rw = $store->rw;
            $kelurahan_desa = $store->kelurahan_desa;
            $kecamatan = $store->kecamatan;
            $kab_kota = $store->kabupaten;
            $kode_pos = $store->kode_pos;
            $no_npwp = $store->no_npwp;
            $kantor_toko_fisik = $store->kantor_toko_fisik;
            $kategori_usaha_omset = $store->kategori_usaha_omset;
            $website = $store->website;

            $imageKTPPath = Storage::path('public/images/profile/'.$ktp_image);
            $templatePath = Storage::path('public/docs/umi/template/Formulir_Pendaftaran_QRIS_Nobu_(NMID_Level).xlsx');
            $userDocsPath = Storage::path('public/docs/umi/user_doc');
            $filename = 'Formulir Pendaftaran NOBU QRIS (NMID) PT BRAHMA ESATAMA_'.$nama_usaha.'_'.date('dmYHis').'.xlsx';
            $fileSave = $userDocsPath.'/'.$filename;
            try {
                File::copy($templatePath, $fileSave);
                $spreadsheet = IOFactory::load($fileSave);
                $sheet1 = $spreadsheet->getSheet(0);
                $sheet1->mergeCells('E6:F6');
                $sheet1->getCell('E6')->setValue($nama_perusahaan);
                $sheet1->mergeCells('E7:F7');
                $sheet1->getCell('E7')->setValue($nama_usaha);
                $sheet1->mergeCells('E9:F9');
                $sheet1->getCell('E9')->setValue($no_npwp);
                $sheet1->mergeCells('E10:F10');
                $sheet1->getCell('E10')->setValue($alamat);
                $sheet1->mergeCells('E11:F11');
                $sheet1->getCell('E11')->setValue($nama_pemilik);
                $sheet1->mergeCells('E12:F12');
                $sheet1->getCell('E12')->setValue($no_hp);
                $sheet1->mergeCells('E13:F13');
                $sheet1->getCell('E13')->setValue($email);

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('no_ktp');
                $drawing->setDescription('No KTP Pemilik Usaha');
                $drawing->setPath($imageKTPPath);
                $drawing->setCoordinates('H6');
                $drawing->getShadow()->setVisible(true);
                $drawing->getShadow()->setDirection(45);
                $drawing->setWorksheet($sheet1);

                $sheet2 = $spreadsheet->getSheet(1);
                $sheet2->mergeCells('D4:E4');
                $sheet2->getCell('D4')->setValue($nama_perusahaan);
                $sheet2->mergeCells('D5:E5');
                $sheet2->getCell('D5')->setValue($nama_pemilik);
                $sheet2->mergeCells('D6:E6');
                $sheet2->getCell('D6')->setValue($tanggal);
                $sheet2->getCell('C11')->setValue($nama_pemilik);
                $sheet2->getCell('D11')->setValue($no_ktp);
                $sheet2->getCell('E11')->setValue($no_hp);
                $sheet2->getCell('F11')->setValue($email);
                $sheet2->getCell('G11')->setValue($nama_usaha);
                $sheet2->getCell('H11')->setValue($jenis_usaha);
                $sheet2->getCell('I11')->setValue($nama_jalan);
                $sheet2->getCell('J11')->setValue($nama_blok);
                $sheet2->getCell('K11')->setValue($rt);
                $sheet2->getCell('L11')->setValue($rw);
                $sheet2->getCell('M11')->setValue($kelurahan_desa);
                $sheet2->getCell('N11')->setValue($kecamatan);
                $sheet2->getCell('O11')->setValue($kab_kota);
                $sheet2->getCell('P11')->setValue($kode_pos);
                $sheet2->getCell('Q11')->setValue($kantor_toko_fisik);
                $sheet2->getCell('R11')->setValue($kategori_usaha_omset);
                $sheet2->getCell('V11')->setValue($website);   

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
                    'file' => $fileSave,
                    'storeName' => $nama_usaha,
                    'jenisUsaha' => $jenis_usaha,
                    'alamat' => $alamat,
                    'kabupaten' => $kab_kota,
                    'kodePos' => $kode_pos
                ];

                Mail::to('ouka.dev@gmail.com')->send(new SendUmiEmail($mailData, $store_identifier));

                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

                $notification = array(
                    'message' => 'Permintaan UMI berhasil diajukan!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch (Exception $e) {
                return $e;
                $this->createHistoryUser($action, $e, 0);
                $notification = array(
                    'message' => 'Pengajuan Umi gagal, harap hubungi admin!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        } else {
            return redirect()->back();
        }
    }
}
