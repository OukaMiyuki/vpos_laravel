<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client as GuzzleHttpClient;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Invoice;
use App\Models\StoreList;
use App\Models\ApiKey;
use App\Models\CallbackApiData;
use App\Models\History;
use App\Models\Tenant;
// use App\Models\HistoryCashbackAdmin;
// use App\Models\QrisWallet;
use Exception;

class PaymentQrisConfirm extends Controller {

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

    private function createHistoryUser($action, $log, $status, $user_id, $user_email){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";
        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $ip, $log, $status);
        }
    }

    public function qrisConfirmPayment(Request $request) : JsonResponse{
        $apiPassword = $request->password;
        $invoice_number = $request->nomor_invoice;
        if($apiPassword == "VposQrisPaymentConfirm"){
            $invoice = Invoice::where('nomor_invoice', $invoice_number)
                                ->where('jenis_pembayaran', 'Qris')
                                ->first();
            if(is_null($invoice) || empty($invoice)){
                History::create([
                    'action' => 'Payment Callback : Invoice cannot be found!',
                    'id_user' => NULL,
                    'email' => NULL,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => $invoice_number,
                    'status' => 1
                ]);
                return response()->json([
                    'message' => 'Invoice cannot be found!',
                    'response-content' => $invoice_number,
                    'status' => 404
                ]);
            }
            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 1,
            ]);
            $contents = "";
            $callback = CallbackApiData::where('email', $invoice->email)->where('id_tenant', $invoice->id_tenant)->first();
            if(!is_null($callback) || !empty( $callback )){
                $client = new GuzzleHttpClient();
                $url = $callback->callback;
                $parameter = $callback->parameter;
                $secret_key_parameter = $callback->secret_key_parameter;
                $secret_key = $callback->secret_key;

                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $data = [
                    $parameter => $invoice->nomor_invoice,
                    $secret_key_parameter => $secret_key,
                    'amount' => $invoice->nominal_bayar,
                    'mdr' => $invoice->mdr,
                    'nominal_mdr' => $invoice->nominal_mdr,
                    'nominal_terima_bersih' => $invoice->nominal_terima_bersih,
                    'status' => 'success',
                ];

                try {
                    $response = $client->post($url, [
                        'headers' => $headers,
                        'json' => $data,
                    ]);
                    $contents = $response->getBody()->getContents();
                    History::create([
                        'action' => 'User Payment Callback : Success | '.$invoice->nomor_invoice,
                        'id_user' => $invoice->id_tenant,
                        'email' => $invoice->email,
                        'lokasi_anda' => 'System Report',
                        'deteksi_ip' => 'System Report',
                        'log' => $contents,
                        'status' => 1
                    ]);
                } catch(Exception $ex){
                    History::create([
                        'action' => 'User Payment Callback : Fail | '.$invoice->nomor_invoice,
                        'id_user' => $invoice->id_tenant,
                        'email' => $invoice->email,
                        'lokasi_anda' => 'System Report',
                        'deteksi_ip' => 'System Report',
                        'log' => $ex,
                        'status' => 1
                    ]);
                }
            } else {
                History::create([
                    'action' => 'User Payment Callback : No Callback provided from the user',
                    'id_user' => $invoice->id_tenant,
                    'email' => $invoice->email,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => 'No callback provided from user',
                    'status' => 1
                ]);
            }

            return response()->json([
                'message' => 'Payment Success!',
                'invoice' => $invoice,
                'response-content' => $contents,
                'status' => 200
            ]);
        } else {
            History::create([
                'action' => 'Unauthorized',
                'id_user' => NULL,
                'email' => NULL,
                'lokasi_anda' => 'System Report',
                'deteksi_ip' => 'System Report',
                'log' => $invoice_number,
                'status' => 1
            ]);
            return response()->json([
                'message' => 'Unauthorized!',
                'status' => 500
            ]);
        }
    }

    public function requestInvoiceNumber(Request $request) : JsonResponse{
        $store_identifier = $request->store_identifier;
        $password = $request->secret_key;
        $lokasi = $request->lokasi;
        $nominal = $request->amount;
        $tanggal_transaksi = Carbon::now();
        $secret_key = "VPOS_Request_No_Invoice_71237577";
        $jenis_pembayaran = "Qris";
        DB::connection()->enableQueryLog();
        if($password == $secret_key) {
            try{
                $store = StoreList::select(['id', 'id_user', 'email', 'store_identifier'])
                                    ->where('store_identifier', $store_identifier)
                                    ->first();

                if(is_null($store) || empty($store)){
                    return response()->json([
                        'message' => 'Invoice Creation Failed, Merchant not found!',
                        'status' => 404
                    ]);
                }

                if(is_null($lokasi) || empty($lokasi)){
                    $lokasi = "Internal Qris";
                }

                $invoice = Invoice::create([
                    'store_identifier' => $store_identifier,
                    'email' => $store->email,
                    'id_tenant' => $store->id_user,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'jenis_pembayaran' => $jenis_pembayaran,
                    'nominal_bayar' => $nominal,
                    'qris_data' => $lokasi
                ]);

                $action = "Request Invoice Number by Merchant : ".$store->store_identifier." Creation Success | ".$invoice->nomor_invoice;
                $id_user = $store->id_user;
                $user_email = $store->email;
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1, $id_user, $user_email);
                return response()->json([
                    'message' => 'Success!',
                    'invoice' => $invoice,
                    'status' => 200
                ]);
            } catch(Exception $e){
                return response()->json([
                    'message' => 'Error!',
                    'store' => $request->store_identifier,
                    'password' => $password,
                    'nominal' => $nominal,
                    'tanggal' => $tanggal_transaksi,
                    'error' => $e,
                    'status' => 500
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized!',
                'status' => 500
            ]);
        }
    }

    public function requestQris(Request $request) : JsonResponse{
        $store_identifier = $request->store_identifier;
        $password = $request->secret_key;
        $nominal = $request->amount;
        $tanggal_transaksi = Carbon::now();
        $jenis_pembayaran = "Qris";
        DB::connection()->enableQueryLog();
        $store = StoreList::select(['id', 'id_user', 'email', 'store_identifier', 'status_umi', 'is_active'])
                            ->where('store_identifier', $store_identifier)
                            ->first();

        if(is_null($store) || empty($store)){
            return response()->json([
                'message' => 'Merchant cannot be found!',
                'status' => 404
            ]);
        } else {
            $tenant = Tenant::select(['tenants.id', 'tenants.id_inv_code', 'tenants.is_active'])->where('id_inv_code', 0)->find($store->id_user);
            if($tenant->is_active == 0 || $tenant->is_active == 2){
                return response()->json([
                    'message' => 'Pembuatan Qris gagal, akun anda belum aktif atau telah dinonaktifkan Admin!',
                    'error' => 'Unauthorized',
                    'status' => 401
                ]);
            }

            if($store->is_active == 0){
                return response()->json([
                    'message' => 'Pembuatan Qris gagal, Merchant anda telah dinonaktifkan oleh admin!',
                    'error' => 'Unauthorized',
                    'status' => 401
                ]);
            }
            $api_key = ApiKey::where('email', $store->email)->where('id_tenant', $store->id_user)->first();
            if(!Hash::check($password, $api_key->key)){
                return response()->json([
                    'message' => 'Unauthorized, API Key not did not match!',
                    'status' => '500',
                ]);
            }
            $invoice = Invoice::create([
                'store_identifier' => $store_identifier,
                'email' => $store->email,
                'id_tenant' => $store->id_user,
                'tanggal_transaksi' => $tanggal_transaksi,
                'jenis_pembayaran' => $jenis_pembayaran,
                'nominal_bayar' => $nominal
            ]);
            $action = "Request Invoice Qris by Merchant : ".$store->store_identifier." Creation Success | ".$invoice->nomor_invoice;
            $id_user = $store->id_user;
            $user_email = $store->email;
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1, $id_user, $user_email);
            return response()->json([
                'message' => 'Success!',
                'invoice' => $invoice,
                'status' => 200
            ]);
        }
    }
}
