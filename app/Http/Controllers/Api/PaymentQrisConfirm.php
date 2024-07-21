<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
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
use App\Models\CallbackHistory;
use App\Models\TenantQrisAccount;
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
        $ip             = "125.164.244.223";
        $clientIP       = request()->header('X-Forwarded-For');
        $PublicIP       = $this->get_client_ip();
        $getLoc         = Location::get($PublicIP);
        $lat            = $getLoc->latitude;
        $long           = $getLoc->longitude;
        $user_location  = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";
        $history = History::create([
            'id_user'   => $user_id,
            'email'     => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $clientIP, $log, $status);
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
                    'action'        => 'Payment Callback : Invoice cannot be found!',
                    'id_user'       => NULL,
                    'email'         => NULL,
                    'lokasi_anda'   => 'System Report',
                    'deteksi_ip'    => 'System Report',
                    'log'           => $invoice_number,
                    'status'        => 1
                ]);
                return response()->json([
                    'message'           => 'Invoice cannot be found!',
                    'response-content'  => $invoice_number,
                    'status'            => 404
                ]);
            } else {
                $invoice->update([
                    'tanggal_pelunasan' => Carbon::now(),
                    'status_pembayaran' => 1,
                ]);
                $contents = "";
                $callback = CallbackApiData::where('email', $invoice->email)->where('id_tenant', $invoice->id_tenant)->first();
                if(!is_null($callback) || !empty( $callback )){
                    $client = new GuzzleHttpClient();
                    $url = $callback->callback;

                    $headers = [
                        'Content-Type' => 'application/json',
                    ];
                    $data = [
                        'login'                 =>  $callback->login,
                        'password'              =>  $callback->password,
                        'api_key'               =>  $callback->secret_key,
                        'partnerTransactionNo'  =>  $invoice->partnerTransactionNo,
                        'partnerReferenceNo'    =>  $invoice->partnerReferenceNo,
                        'amount'                =>  $invoice->nominal_bayar,
                        'mdrPaymentAmount'      =>  $invoice->nominal_terima_bersih,
                        'paymentStatus'         =>  "PAID",
                        'invoice_number'        =>  $invoice->nomor_invoice,
                        'paymentTimeStamp'      =>  date('d-m-Y H:i:s'),
                        'responseStatus'        =>  "SUCCESS",
                        'status'                =>  20011,
                    ];

                    try {
                        $response = $client->post($url, [
                            'headers' => $headers,
                            'json' => $data,
                        ]);
                        $contents = $response->getBody()->getContents();
                        $contentEncode = json_decode($contents);

                        $callbackDetail = CallbackHistory::create([
                                            'nomor_callback'            =>  date('YmdHisU'),
                                            'nomor_invoice'             =>  $invoice->nomor_invoice,
                                            'responseStatus'            =>  $contentEncode->responseStatus,
                                            'responseCode'              =>  $contentEncode->responseCode,
                                            'responseDescription'       =>  $contentEncode->responseDescription,
                                            'partnerTransactionNo'      =>  $contentEncode->partnerTransactionNo,
                                            'partnerReferenceNo'        =>  $contentEncode->partnerReferenceNo,
                                            'partnerCallbackReference'  =>  $contentEncode->partnerCallbackReference,
                                            'partnerTransactionStatus'  =>  $contentEncode->partnerTransactionStatus,
                                            'partnerPaymentStatus'      =>  $contentEncode->partnerPaymentStatus,
                                            'partnerPaymentTimeStamp'   =>  $contentEncode->partnerPaymentTimeStamp,
                                        ]);

                        History::create([
                            'action' => 'User Payment Callback : Success | '.$invoice->nomor_invoice,
                            'id_user' => $invoice->id_tenant,
                            'email' => $invoice->email,
                            'lokasi_anda' => 'System Report',
                            'deteksi_ip' => 'System Report',
                            'log' => $contentEncode->responseCode.' | Callback ID : '.$callbackDetail->nomor_callback,
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
            }
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
        $validator = Validator::make(request()->all(), [
            'store_identifier'      =>  'required|string',
            'secret_key'            =>  'required|string',
            'amount'                =>  'required|numeric',
            'partnerTransactionNo'  =>  'required|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'   =>  "Invalid Value or NULL",
                'errors'    =>  $validator->errors(),
                'status'    =>  20012
            ]);
        }

        $store_identifier       =   $request->store_identifier;
        $password               =   $request->secret_key;
        $nominal                =   $request->amount;
        $partnerTransactionNo   =   $request->partnerTransactionNo;
        $partnerReferenceNo     =   $request->partnerReferenceNo;
        $tanggal_transaksi      =   Carbon::now();
        $jenis_pembayaran       =   "Qris";

        if(is_null($request->store_identifier) || empty($request->store_identifier)){
            return response()->json([
                'message'   =>  "Store Identifier is NULL",
                'status'    =>  20013
            ]);
        }else if(is_null($request->amount) || empty($request->amount)){
            return response()->json([
                'message'   =>  "Amount is NULL",
                'status'    =>  20014
            ]);
        } else if(is_null($request->partnerTransactionNo) || empty($request->partnerTransactionNo)){
            return response()->json([
                'message'   =>  "Partner Transaction Number Is NULL",
                'status'    =>  20015
            ]);
        } else if(is_null($request->secret_key) || empty($request->secret_key)){
            return response()->json([
                'message'   =>  "Secret Key Is NULL",
                'status'    =>  20016
            ]);
        }

        DB::connection()->enableQueryLog();
        $store = StoreList::select(['id', 'id_user', 'email', 'store_identifier', 'status_umi', 'is_active'])
                          ->where('store_identifier', $store_identifier)
                          ->first();

        if(is_null($store) || empty($store)){
            return response()->json([
                'message'   =>  'Wrong Store Identifier, Merchant cannot be found',
                'status'    =>  20018
            ]);
        } else {
            $api_key = ApiKey::where('email', $store->email)->where('id_tenant', $store->id_user)->first();
            if(!Hash::check($password, $api_key->key)){
                return response()->json([
                    'message'   =>  'Wrong Secret Key',
                    'status'    =>  20017
                ]);
            }
            $tenant = Tenant::select(['tenants.id', 'tenants.id_inv_code', 'tenants.phone_number_verified_at', 'tenants.is_active'])->where('id_inv_code', 0)->find($store->id_user);
            if(is_null($tenant->phone_number_verified_at) || empty($tenant->phone_number_verified_at) || $tenant->phone_number_verified_at == "" || $tenant->phone_number_verified_at == NULL){
                return response()->json([
                    'message'   =>  'Your account whatsapp number has not been verified yet, please verify your number first',
                    'status'    =>  20020
                ]);
            } else {
                if($tenant->is_active == 0){
                    return response()->json([
                        'message'   =>  'Your acount has not been activated, please contact our admin',
                        'status'    =>  20019
                    ]);
                } else if($tenant->is_active == 2){
                    return response()->json([
                        'message'   =>  'Your account has been deactivated by the admin, please contact damin for further information',
                        'status'    =>  20021
                    ]);
                }
    
                if($store->is_active == 0){
                    return response()->json([
                        'message' => 'Your merchant is deactivated by admin, please contact the admin for further information',
                        'status' => 20022
                    ]);
                }

                $invoiceCheck = Invoice::where('partnerTransactionNo', $partnerTransactionNo)->first();

                if(!is_null($invoiceCheck) || !empty($invoiceCheck)){
                    return response()->json([
                        'message'   =>  'Duplicate Transaction, this transaction number has been requested before',
                        'status'    =>  20023
                    ]);
                } else {
                    if($nominal <=0){
                        return response()->json([
                            'message'   =>  'The amount transaction value is lesser than minim amount, the minimum transaction is Rp. 1',
                            'status'    =>  20025
                        ]);
                    } else if($nominal > 10000000){
                        return response()->json([
                            'message'   =>  'The amount transaction value is exceeded, the maximum transaction is Rp. 10.000.000,00',
                            'status'    =>  20024
                        ]);
                    } else {
                        try{
                            $invoice = Invoice::create([
                                'store_identifier'          =>  $store_identifier,
                                'email'                     =>  $store->email,
                                'id_tenant'                 =>  $store->id_user,
                                'partnerTransactionNo'      =>  $partnerTransactionNo,
                                'partnerReferenceNo'        =>  $partnerReferenceNo,
                                'tanggal_transaksi'         =>  $tanggal_transaksi,
                                'jenis_pembayaran'          =>  $jenis_pembayaran,
                                'nominal_bayar'             =>  $nominal
                            ]);
                            $id_user = $store->id_user;
                            $user_email = $store->email;
                            
                            if($invoice->qris_response == 211000 || $invoice->qris_response == "211000"){
                                if(!is_null($invoice) && !is_null($invoice->id)){
                                    $action = "Request Invoice Qris by Merchant : ".$store->store_identifier." Creation Success | ".$invoice->nomor_invoice;
                                    $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1, $id_user, $user_email);
                                    $invoiceCreated = Invoice::find($invoice->id);
                                    $invoiceDataResponse = array(
                                        'store_identifier'      =>  $invoiceCreated->store_identifier,
                                        'invoice_number'        =>  $invoiceCreated->nomor_invoice,
                                        'partnerTransactionNo'  =>  $invoiceCreated->partnerTransactionNo,
                                        'partnerReferenceNo'    =>  $invoiceCreated->partnerReferenceNo,
                                        'transactionDate'       =>  $invoiceCreated->tanggal_transaksi,
                                        'jenisPembayaran'       =>  $invoiceCreated->jenis_pembayaran,
                                        'qris_data'             =>  $invoiceCreated->qris_data,
                                        'amount'                =>  $invoiceCreated->nominal_bayar,
                                        'nominal_mdr'           =>  $invoiceCreated->nominal_mdr,
                                        'mdrPaymentAmount'      =>  $invoiceCreated->nominal_terima_bersih,
                                    );
                                    return response()->json([
                                        'message'               =>  'Transaction Success',
                                        'transactionData'       =>  $invoiceDataResponse,
                                        'status'                =>  20011
                                    ]);
                                } else {
                                    return response()->json([
                                        'message'   =>  "There's an internal server error, please contact the admin for further action",
                                        'status'    =>  20026
                                    ]);
                                }
                            } else {
                                $action = "Request Invoice Qris by Merchant : ".$store->store_identifier." Creation Fail - Partner Transaction Number | ".$invoice->partnerTransactionNo;
                                $this->createHistoryUser($action, $invoice->qris_response, 0, $id_user, $user_email);
                                if(!is_null($invoice) && !is_null($invoice->id)){
                                    $invoiceCreated = Invoice::find($invoice->id);
                                    $invoiceCreated->delete();
                                }
                                return response()->json([
                                    'message'   =>  "There's an internal server error, please contact the admin for further action",
                                    'status'    =>  20026
                                ]);
                            }
                        } catch(Exception $e){
                            $id_user = $store->id_user;
                            $user_email = $store->email;
                            $action = "Request Invoice Qris by Merchant : ".$store->store_identifier." Creation Fail - Partner Transaction Number | ".$invoice->partnerTransactionNo;
                            $this->createHistoryUser($action, $e, 0, $id_user, $user_email);
                            if(!is_null($invoice) && !is_null($invoice->id)){
                                $invoiceCreated = Invoice::find($invoice->id);
                                $invoiceCreated->delete();
                            }
                            return response()->json([
                                'message'   =>  "There's an internal server error, please contact the admin for further action",
                                'status'    =>  20026
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function inquiryQris(Request $request) : JsonResponse{
        $validator = Validator::make($request->all(), [
            'store_identifier'      =>  'required|string',
            'secret_key'            =>  'required|string',
            'partnerTransactionNo'  =>  'required|string',
            'invoice_number'        =>  'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'   =>  "Invalid Value or NULL",
                'errors'    =>  $validator->errors(),
                'status'    =>  20012
            ]);
        }

        $store_identifier       =   $request->store_identifier;
        $password               =   $request->secret_key;
        $partnerTransactionNo   =   $request->partnerTransactionNo;
        $nomor_invoice          =   $request->invoice_number;

        $store = StoreList::select(['id', 'id_user', 'email', 'store_identifier', 'status_umi', 'is_active'])
                          ->where('store_identifier', $store_identifier)
                          ->first();

        if(is_null($store) || empty($store)){
            return response()->json([
                'message'   =>  'Wrong Store Identifier, Merchant cannot be found',
                'status'    =>  20018
            ]);
        } else {
            $api_key = ApiKey::where('email', $store->email)->where('id_tenant', $store->id_user)->first();
            if(!Hash::check($password, $api_key->key)){
                return response()->json([
                    'message'   =>  'Wrong Secret Key',
                    'status'    =>  20017
                ]);
            }
            $tenant = Tenant::select(['tenants.id', 'tenants.id_inv_code', 'tenants.phone_number_verified_at', 'tenants.is_active'])->where('id_inv_code', 0)->find($store->id_user);
            if(is_null($tenant->phone_number_verified_at) || empty($tenant->phone_number_verified_at) || $tenant->phone_number_verified_at == "" || $tenant->phone_number_verified_at == NULL){
                return response()->json([
                    'message'   =>  'Your account whatsapp number has not been verified yet, please verify your number first',
                    'status'    =>  20020
                ]);
            } else {
                if($tenant->is_active == 0){
                    return response()->json([
                        'message'   =>  'Your acount has not been activated, please contact our admin',
                        'status'    =>  20019
                    ]);
                } else if($tenant->is_active == 2){
                    return response()->json([
                        'message'   =>  'Your account has been deactivated by the admin, please contact damin for further information',
                        'status'    =>  20021
                    ]);
                }
            }

            if($store->is_active == 0){
                return response()->json([
                    'message'   => 'Your merchant is deactivated by admin, please contact the admin for further information',
                    'status'    => 20022
                ]);
            }

            $invoiceCheck = Invoice::where('partnerTransactionNo', $partnerTransactionNo)->where('nomor_invoice', $nomor_invoice)->first();

            if(is_null($invoiceCheck) || empty($invoiceCheck)){
                return response()->json([
                    'message'   => "Invalid Transaction, Transaction Number Can't Be Found",
                    'status'    => 30012
                ]);
            } else {
                $client = new GuzzleHttpClient();
                $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
                $data = "";
                $postResponse = "";
                $paymentStatusServer = 0;
                $qrisAccount = TenantQrisAccount::where('store_identifier', $store_identifier)->where('id_tenant', $invoiceCheck->id_tenant)->first();
                if(is_null($qrisAccount) || empty($qrisAccount)){
                    try{
                        $postResponse = $client->request('POST',  $url, [
                            'form_params' => [
                                'secret_key'    => "Vpos71237577",
                                'transNo'       => $invoiceCheck->nomor_invoice,
                                'pos_id'        => "VP",
                                'storeID'       => "ID2023294446943"
                            ]
                        ]);
                    } catch(Exception $e){
                        return response()->json([
                            'message'   =>  "There's an internal server error, please contact the admin for further action",
                            'status'    =>  20026
                        ]);
                    }
                        
                } else {
                    try{
                        $postResponse = $client->request('POST',  $url, [
                            'form_params' => [
                                'secret_key'    => "Vpos71237577",
                                'transNo'       => $invoiceCheck->nomor_invoice,
                                'pos_id'        => "VP",
                                'storeID'       => $qrisAccount->qris_store_id
                            ]
                        ]);
                    } catch(Exception $e){
                        return response()->json([
                            'message'   =>  "There's an internal server error, please contact the admin for further action",
                            'status'    =>  20026
                        ]);
                    }
                }

                $data = json_decode($postResponse->getBody());
                
                if(!is_null($data) || !empty($data)){
                    if($data->data->responseStatus == "Failed" 
                        || $data->data->messageDetail == "The transaction is invalid or has not been paid." 
                        || $data->data->responseDescription == "Data Not Found" 
                        || $data->data->responseCode == "921009" 
                        || $data->data->responseCode == 921009) {
                        $paymentStatusServer = 0;
                    }

                    if($data->data->responseStatus == "Success" 
                        || $data->data->messageDetail == "The transaction has been paid." 
                        || $data->data->responseDescription == "Success" 
                        || $data->data->responseCode == "921000" 
                        || $data->data->responseCode == 921000) {
                        $paymentStatusServer = 1;
                    }

                    $invoice = array(
                        'store_identifier'      =>  $invoiceCheck->store_identifier,
                        'invoice_number'        =>  $invoiceCheck->nomor_invoice,
                        'partnerTransactionNo'  =>  $invoiceCheck->partnerTransactionNo,
                        'partnerReferenceNo'    =>  $invoiceCheck->partnerReferenceNo,
                        'transactionDate'       =>  $invoiceCheck->tanggal_transaksi,
                        'jenisPembayaran'       =>  $invoiceCheck->jenis_pembayaran,
                        'qris_data'             =>  $invoiceCheck->qris_data,
                        'amount'                =>  $invoiceCheck->nominal_bayar,
                        'nominal_mdr'           =>  $invoiceCheck->nominal_mdr,
                        'mdrPaymentAmount'      =>  $invoiceCheck->nominal_terima_bersih,
                    );

                    if($invoiceCheck->status_pembayaran == 0 && $paymentStatusServer == 0){
                        return response()->json([
                            'message'           =>  "Transaction Found",
                            'transactionData'   => $invoice,
                            'paymentStatus'     => "UNPAID",
                            'status'            =>  30011
                        ]);
                    } else if($invoiceCheck->status_pembayaran == 1 && $paymentStatusServer == 1){
                        return response()->json([
                            'message'           =>  "Transaction Found",
                            'transactionData'   =>  $invoice,
                            'paymentStatus'     =>  "PAID",
                            'paymentDate'       =>  $invoiceCheck->updated_at,
                            'status'            =>  30011
                        ]);
                    } else {
                        return response()->json([
                            'message'           =>  "Invalid Payment Status, pease contact admin",
                            'transactionData'   =>  $invoice,
                            'paymentStatus'     =>  "INVALID",
                            'status'            =>  30013
                        ]);
                    }
                }
            }
        }
    }
}
