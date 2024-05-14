<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Models\Invoice;
use App\Models\StoreDetail;
use App\Models\QrisWallet;

class PaymentQrisConfirm extends Controller {
    public function qrisConfirmPayment(Request $request) : JsonResponse{
        $apiPassword = $request->password;
        if($apiPassword == "VposQrisPaymentConfirm"){
            $invoice = Invoice::where('nomor_invoice', $request->nomor_invoice)
                                ->where('jenis_pembayaran', 'Qris')
                                ->first();

            $store = StoreDetail::where('store_identifier', $invoice->store_identifier)
                            ->where('id_tenant', $invoice->id_tenant)
                            ->first();

            $qrisWallet = QrisWallet::where('id_user', $store->id_tenant)
                                ->where('email', $store->email)
                                ->first();

            $presentaseKurang = $invoice->nominal_bayar*0.007;
            $hasilKurang = $invoice->nominal_bayar-$presentaseKurang;

            $qrisWalletSaldoNow = $qrisWallet->saldo;
            $saldo = $qrisWalletSaldoNow+$hasilKurang;

            $qrisWallet->update([
                'saldo' => $saldo 
            ]);

            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 1
            ]);

            return response()->json([
                'message' => 'Payment Success!',
                'presentase-kurang' => $presentaseKurang,
                'hasil-kurang' => $hasilKurang,
                'saldo-sekarang' => $qrisWalletSaldoNow,
                'hasil-saldo' => $saldo,
                'qris-wallet' => $qrisWallet,
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
}
