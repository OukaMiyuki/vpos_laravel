<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\DetailTenant;
use App\Models\StoreDetail;
use App\Models\RekeningTenant;
use App\Models\UmiRequest;
use GuzzleHttp\Client;
use App\Mail\SendUmiEmail;
use File;
use Mail;

class ProfileController extends Controller{
    public function tenantSettings(){
        return view('tenant.tenant_settings');
    }

    public function profile(){
        return view('tenant.tenant_profile');
    }

    public function profileAccountUpdate(Request $request){
        $profileInfo = Tenant::find(auth()->user()->id);

        $profileInfo->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function profileInfoUpdate(Request $request){
        $profileInfo = DetailTenant::find(auth()->user()->detail->id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = $profileInfo->name;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($profileInfo->detail->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/profile/'.$profileInfo->detail->photo);
                $file->move($storagePath, $filename);
            }

            $profileInfo->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'photo' => $filename,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } else {
            $profileInfo->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('tenant.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth::user()->password)){
            $notification = array(
                'message' => 'Password lama tidak sesuai!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        Tenant::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = array(
            'message' => 'Password berhasil diperbarui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    
    public function storeProfileSettings(){
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_store_detail', compact('tenantStore'));
    }

    public function storeProfileSettingsUPdate(Request $request) {
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)->first();
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = $request->nama;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($tenantStore->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/profile/'.$tenantStore->photo);
                $file->move($storagePath, $filename);
            }

            $tenantStore->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'kode_pos' => $request->kode_pos,
                'no_telp_toko' => $request->no_telp,
                'jenis_usaha' => $request->jenis,
                //'status_umi' => $request->umi,
                'catatan_kaki' => $request->catatan,
                'photo' => $filename
            ]);;

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $tenantStore->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'kode_pos' => $request->kode_pos,
                'no_telp_toko' => $request->no_telp,
                'jenis_usaha' => $request->jenis,
                //'status_umi' => $request->umi,
                'catatan_kaki' => $request->catatan,
            ]);

            $notification = array(
                'message' => 'Data berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function rekeingSetting(){
        $rekening = RekeningTenant::where('id_tenant', auth()->user()->id)->first();
        $client = new Client();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;
        //dd($data->bankSwiftList);
        return view('tenant.tenant_rekening_setting', compact('rekening', 'dataBankList'));
    }

    public function umiRequestForm(){
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)->first();
        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }
        return view('tenant.tenant_umi_request', compact('umiRequest'));
    }

    public function umiRequestProcess(Request $request){
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)->first();
        if(empty($umiRequest) || is_null($umiRequest) || $umiRequest == ""){
            $tanggal = date("j F Y", strtotime(date('Y-m-d')));
            $nama_pemilik = $request->nama_pemilik;
            $no_ktp = $request->no_ktp;
            $no_hp = $request->no_hp;
            $email = $request->email;
            $nama_usaha = $request->nama_usaha;
            $jenis_usaha = $request->jenis_usaha;
            $alamat = $request->alamat;
            $kab_kota = $request->kab_kota;
            $kode_pos = $request->kode_pos;
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
                    'tanggal_pengajuan' => Carbon::now(),
                    'file_path' => $filename
                ]);
                $mailData = [
                    'title' => 'Formulir Pendaftaran UMI',
                    'body' => 'This is for testing email using smtp.',
                    'file' => $fileSave
                ];
                 
                Mail::to('amarwibianto@gmail.com')->send(new SendUmiEmail($mailData));
                   
                //dd("Email is sent successfully.");
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
}
