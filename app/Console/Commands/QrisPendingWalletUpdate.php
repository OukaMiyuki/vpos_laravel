<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\SettlementDateSetting;
use App\Models\QrisWallet;
use App\Models\HistoryCashbackAdmin;
use App\Models\History;

class QrisPendingWalletUpdate extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateQris:qris-pending-wallet-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer Saldo Qris ke Real Saldo Qris';

    /**
     * Execute the console command.
     */
    public function handle() {
        $now = date('Y-m-d');
        $now=date('Y-m-d', strtotime($now));
        $settlementDate = SettlementDateSetting::latest()->get();
        $dateCollection = 0;
        foreach($settlementDate as $settlement){
            $startDate = date('Y-m-d', strtotime($settlement->stat_date));
            $endDate = date('Y-m-d', strtotime($settlement->end_date));
            if (($now >= $startDate) && ($now <= $endDate)) {
                $dateCollection+=1;
            }
        }
        echo $dateCollection;
        if($dateCollection != 0){
            History::create([
                'action' => 'Settlement Update : Pending due to holiday!',
                'id_user' => NULL,
                'email' => NULL,
                'lokasi_anda' => 'System Report',
                'deteksi_ip' => 'System Report',
                'log' => Carbon::now(),
                'status' => 1
            ]);
        } else {
            // $invoiceSettlementPending = Invoice::select([
            //                                             'id',
            //                                             'id_tenant',
            //                                             'email',
            //                                             "store_identifier",
            //                                             DB::raw("(sum(nominal_mdr)) as total_nominal_mdr"),
            //                                             DB::raw("(sum(nominal_terima_bersih)) as total_penghasilan"),
            //                                         ])
            //                                         ->where('settlement_status', 0)
            //                                         ->where('jenis_pembayaran', 'Qris')
            //                                         ->where('status_pembayaran', 1)
            //                                         ->whereDate('tanggal_transaksi', '!=', Carbon::now())
            //                                         ->groupBy(['id','store_identifier', 'email', 'id_tenant'])
            //                                         ->get();

            $invoiceSettlementPending = Invoice::where('settlement_status', 0)
                                                ->where('jenis_pembayaran', 'Qris')
                                                ->where('status_pembayaran', 1)
                                                ->whereDate('tanggal_transaksi', '!=', Carbon::now())
                                                ->get();

            foreach($invoiceSettlementPending as $invoice){
                $qris = QrisWallet::where('id_user', $invoice->id_tenant)->where('email', $invoice->email)->first();
                $qrisSaldo = $qris->saldo;
                dd($qrisSaldo);
                // $saldoTransfer = $invoice->nominal_terima_bersih;
                // $qris->update([
                //     'saldo' => $qrisSaldo+$saldoTransfer
                // ]);
                // $qrisAdminWallet = QrisWallet::where('id_user', 1)->where('email', 'adminsu@visipos.id')->find(1);
                // $saldoAdmin = $qrisAdminWallet->saldo;
                // // $nominal_mdr = $invoice->nominal_terima_bersih;
                // $insentif_cashback = $saldoTransfer*0.25;
    
                // $qrisAdminWallet->update([
                //     'saldo' => $saldoAdmin+$insentif_cashback
                // ]);
    
                // HistoryCashbackAdmin::create([
                //     'id_invoice' => $invoice->id,
                //     'nominal_terima_mdr' => $insentif_cashback
                // ]);

                // // Invoice::find($invoice->id)->update([
                // //     'settlement_status' => 1
                // // ]);
                // $invoice->update([
                //     'settlement_status' => 1
                // ]);
            }
        }
    }
}
