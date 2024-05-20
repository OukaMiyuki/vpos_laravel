<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Invoice;
use App\Models\StoreList;
// use App\Models\HistoryCashbackAdmin;
// use App\Models\QrisWallet;
use Exception;

class PaymentQrisConfirm extends Controller {
    public function qrisConfirmPayment(Request $request) : JsonResponse{
        $apiPassword = $request->password;
        // $amount = $request->amount;
        // $mdr = 0;
        if($apiPassword == "VposQrisPaymentConfirm"){
            $invoice = Invoice::where('nomor_invoice', $request->nomor_invoice)
                                ->where('jenis_pembayaran', 'Qris')
                                ->first();
            // $qrisAdminWallet = QrisWallet::where('id_user', 8)->find(6);
            // $saldoAdmin = $qrisAdminWallet->saldo;

            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 1,
            ]);

            // $nominal_mdr = $invoice->nominal_mdr;
            // $insentif_cashback = $nominal_mdr*0.25;

            // $qrisAdminWallet->update([
            //     'saldo' => $saldoAdmin+$insentif_cashback
            // ]);

            // HistoryCashbackAdmin::create([
            //     'id_invoice' => $invoice->id,
            //     'nominal_terima_mdr' => $insentif_cashback
            // ]);

            // $store = StoreDetail::where('store_identifier', $invoice->store_identifier)
            //                 ->where('id_tenant', $invoice->id_tenant)
            //                 ->first();

            // $qrisWallet = QrisWallet::where('id_user', $store->id_tenant)
            //                     ->where('email', $store->email)
            //                     ->first();

            // $presentaseKurang = $invoice->nominal_bayar*0.007;
            // $hasilKurang = $invoice->nominal_bayar-$presentaseKurang;

            // $qrisWalletSaldoNow = $qrisWallet->saldo;
            // $saldo = $qrisWalletSaldoNow+$hasilKurang;

            // $qrisWallet->update([
            //     'saldo' => $saldo 
            // ]);

            // $invoice->update([
            //     'tanggal_pelunasan' => Carbon::now(),
            //     'status_pembayaran' => 1
            // ]);

            return response()->json([
                'message' => 'Payment Success!',
                'invoice' => $invoice,
                'status' => 200
            ]);
        } else {
            
            return response()->json([
                'message' => 'Unauthorized!',
                'status' => 500
            ]);
        }
    }
    
    public function requestInvoiceNumber(Request $request) : JsonResponse{
        $store_identifier = $request->store_identifier;
        $password = $request->secret_key;
        $nominal = $request->amount;
        $tanggal_transaksi = Carbon::now();
        $secret_key = "VPOS_Request_No_Invoice_71237577";
        $jenis_pembayaran = "Qris";

        if($password == $secret_key) {
            try{
                $store = StoreList::select(['id', 'id_user', 'email', 'store_identifier'])
                                    ->where('store_identifier', $store_identifier)
                                    ->first();
                $invoice = Invoice::create([
                    'store_identifier' => $store_identifier,
                    'email' => $store->email,
                    'id_tenant' => $store->id_user,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'jenis_pembayaran' => $jenis_pembayaran,
                    'nominal_bayar' => $nominal
                ]);

                return response()->json([
                    'message' => 'Success!',
                    'invoice' => $invoice,
                    'status' => 200
                ]);
            } catch(Exception $e){
                return response()->json([
                    'message' => 'Error!',
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
}
