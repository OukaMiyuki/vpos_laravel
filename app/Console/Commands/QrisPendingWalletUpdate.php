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
use App\Models\Tenant;
use App\Models\SettlementHstory;
use App\Models\Settlement;
use Exception;

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
        //echo $dateCollection;
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
            try{
                $code = "STL";
                $dateCode = Carbon::now()->format('dmY');
                $tenantinvoice = Tenant::with([
                                                'invoice' => function($query){
                                                    $query->where('settlement_status', 0)
                                                        ->where('jenis_pembayaran', 'Qris')
                                                        ->where('status_pembayaran', 1)
                                                        ->whereDate('tanggal_transaksi', '!=', Carbon::now());
                                                }
                                            ])
                                            ->get();
                $settlement = Settlement::create([
                    'nomor_settlement' => $code.$dateCode,
                    'tanggal_settlement' => Carbon::now(),
                ]);
                foreach($tenantinvoice as $sumInvoice){
                    $qrisWalletTenant = QrisWallet::where('id_user', $sumInvoice->id)->where('email', $sumInvoice->email)->first();
                    if(!is_null($qrisWalletTenant) || empty($qrisWalletTenant)){
                        $totalSum = $sumInvoice->invoice->sum('nominal_terima_bersih');
                        $totalSumFloor = floor($totalSum);
                        $saldoQrisTenant = $qrisWalletTenant->saldo;
                        $qrisWalletTenant->update([
                            'saldo' => $saldoQrisTenant+$totalSumFloor
                        ]);
                        echo "Nama : ".$sumInvoice->name." | ".$totalSumFloor." | Periode : ".Carbon::now();
                        $totalCashback = 0;
                        foreach($sumInvoice->invoice as $invoice){
                            $nominal_mdr = $invoice->nominal_mdr;
                            $insentif_cashback = $nominal_mdr*0.25;
                            $insentif_cashbackFloor = floor($insentif_cashback);
                            $qrisWalletAdmin =  QrisWallet::where('id_user', 1)->where('email', 'adminsu@visipos.id')->find(1);
                            $qrisWalletAdminSaldo = $qrisWalletAdmin->saldo;
                            $qrisWalletAdmin->update([
                                'saldo' => $qrisWalletAdminSaldo+$insentif_cashbackFloor
                            ]);
                            $totalCashback+=$insentif_cashbackFloor;
                            HistoryCashbackAdmin::create([
                                'id_invoice' => $invoice->id,
                                'nominal_terima_mdr' => $insentif_cashbackFloor
                            ]);
                            Invoice::find($invoice->id)->update([
                                'settlement_status' => 1
                            ]);
                        }
                        SettlementHstory::create([
                            'id_user' => $sumInvoice->id,
                            'id_settlement' => $settlement->id,
                            'email' => $sumInvoice->email,
                            'settlement_time_stamp' => Carbon::now(),
                            'nominal_settle' => $totalSumFloor,
                            'nominal_insentif_cashback' => $totalCashback
                        ]);
                    } else {
                        echo "Wallet not found".$sumInvoice->email;
                    }
                }
                History::create([
                    'action' => 'Settlement Update Success!',
                    'id_user' => NULL,
                    'email' => NULL,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => Carbon::now(),
                    'status' => 1
                ]);
                $settlement->status = 1;
                $settlement->save();
            } catch(Exception $e){
                History::create([
                    'action' => 'Settlement Update Failed! '.Carbon::now(),
                    'id_user' => NULL,
                    'email' => NULL,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => $e,
                    'status' => 0
                ]);
                $settlement->status = 0;
                $settlement->save();
            }
        }
    }
}
