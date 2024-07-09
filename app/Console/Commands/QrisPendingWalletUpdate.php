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
use App\Models\SettlementPending;
use App\Models\HistoryCashbackPending;
use App\Models\SettlementLog;
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
        DB::connection()->enableQueryLog();
        $now = date('Y-m-d');
        $now=date('Y-m-d', strtotime($now));
        $settlementNote = "Settlement periode ".Carbon::now()->format('d-m-Y');
        $settlementDate = SettlementDateSetting::latest()->get();
        $dateCollection = 0;
        $today = new Carbon();

        foreach($settlementDate as $settlement){
            $startDate = date('Y-m-d', strtotime($settlement->stat_date));
            $endDate = date('Y-m-d', strtotime($settlement->end_date));
            if (($now >= $startDate) && ($now <= $endDate)) {
                $dateCollection+=1;
            }
        }
        //echo $dateCollection;
        if($dateCollection != 0 || ($today->dayOfWeek == Carbon::SATURDAY) ||  ($today->dayOfWeek == Carbon::SUNDAY)){
            $code = "PD-STL";
            $dateCode = $code.Carbon::now()->format('dmY');
            $tenantinvoice = Tenant::with([
                                            'invoice' => function($query){
                                                $query->where('settlement_status', 0)
                                                      ->where('jenis_pembayaran', 'Qris')
                                                      ->where('status_pembayaran', 1)
                                                      ->whereDate('tanggal_transaksi', '!=', Carbon::now());
                                                }
                                        ])
                                        ->get();

            foreach($tenantinvoice as $sumInvoice){
                $totalSum = $sumInvoice->invoice->sum('nominal_terima_bersih');
                $totalSumFloor = floor($totalSum);
                echo "Pending Settlement Insert - Nama : ".$sumInvoice->name." | ".$totalSumFloor." | Periode : ".Carbon::now()."\n";
                $totalCashback = 0;
                foreach($sumInvoice->invoice as $invoice){
                    $nominal_mdr = $invoice->nominal_mdr;
                    $insentif_cashback = $nominal_mdr*0.25;
                    $insentif_cashbackFloor = floor($insentif_cashback);
                    $totalCashback+=$insentif_cashbackFloor;
                    HistoryCashbackPending::create([
                        'id_invoice' => $invoice->id,
                        'nominal_terima_mdr' => $insentif_cashbackFloor,
                        'periode_transaksi' => Carbon::now()
                    ]);
                    Invoice::find($invoice->id)->update([
                        'settlement_status' => 1
                    ]);
                }
                SettlementPending::create([
                    'id_user' => $sumInvoice->id,
                    'email' => $sumInvoice->email,
                    'nomor_settlement_pending' => $dateCode,
                    'settlement_schedule' => Carbon::now(),
                    'nominal_settle' => $totalSumFloor,
                    'nominal_insentif_cashback' => $totalCashback,
                    'periode_transaksi' => Carbon::yesterday(),
                    'settlement_pending_status' => 1,
                ]);
            }
            $action = "";
            if($dateCollection != 0){
                $action = "Settlement pending due to Holiday | ".Carbon::now()->format('d-m-Y');
            }
            if($today->dayOfWeek == Carbon::SATURDAY){
                $action = "Settlement pending due to weekend and today is Saturday | ".Carbon::now()->format('d-m-Y');
            }
            if($today->dayOfWeek == Carbon::SUNDAY){
                $action = "Settlement pending due to weekend and today is Sunday | ".Carbon::now()->format('d-m-Y');
            }

            SettlementLog::create([
                'settlement_id' => $dateCode,
                'action' => $action,
                'log_timestamp' => Carbon::now(),
            ]);

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
                        echo "Nama : ".$sumInvoice->name." | ".$totalSumFloor." | Periode : ".Carbon::now()."\n";
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
                                'nominal_terima_mdr' => $insentif_cashbackFloor,
                                'periode_transaksi' => Carbon::yesterday()
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
                            'nominal_insentif_cashback' => $totalCashback,
                            'status' => 1,
                            'note' => $settlementNote,
                            'periode_transaksi' => Carbon::yesterday()
                        ]);
                        $action = "Settlement for today has been settled | ".Carbon::now()->format('d-m-Y');
                        SettlementLog::create([
                            'settlement_id' => $code.$dateCode,
                            'action' => $action,
                            'log_timestamp' => Carbon::now(),
                        ]);
                    } else {
                        echo "Wallet not found".$sumInvoice->email;
                    }
                }
                $settlementPending = SettlementPending::where('settlement_pending_status', 0)->get();
                if(!is_null($settlementPending) || !empty($settlementPending)){
                    foreach($settlementPending as $stlPending){
                        $qrisWalletTenant = QrisWallet::where('id_user', $stlPending->id)->where('email', $stlPending->email)->first();
                        if(!is_null($qrisWalletTenant) || empty($qrisWalletTenant)){
                            $saldoQrisTenant = $qrisWalletTenant->saldo;
                            $qrisWalletTenant->update([
                                'saldo' => $saldoQrisTenant+$stlPending->nominal_settle
                            ]);
                            $qrisWalletAdmin =  QrisWallet::where('id_user', 1)->where('email', 'adminsu@visipos.id')->first();
                            $qrisWalletAdminSaldo = $qrisWalletAdmin->saldo;
                            $qrisWalletAdmin->update([
                                'saldo' => $qrisWalletAdminSaldo+$stlPending->nominal_insentif_cashback
                            ]);
                            SettlementHstory::create([
                                'id_user' => $stlPending->id_user,
                                'id_settlement' => $settlement->id,
                                'email' => $stlPending->email,
                                'settlement_time_stamp' => Carbon::now(),
                                'nominal_settle' => $stlPending->nominal_settle,
                                'nominal_insentif_cashback' => $stlPending->nominal_insentif_cashback,
                                'status' => 1,
                                'note' => "Settlement Pending : ".$stlPending->nomor_settlement_pending." | Scheduled on date : ".$stlPending->settlement_schedule."| is Settled On : ".Carbon::now()->format('d-m-Y'),
                                'periode_transaksi' => $stlPending->periode_transaksi
                            ]);
                            $stlPending->update([
                                'settlement_pending_status' => 1
                            ]);
                            SettlementLog::create([
                                'settlement_id' => $stlPending->nomor_settlement_pending,
                                'action' => "Settlement pending for ".$stlPending->nomor_settlement_pending." | has been settled on".Carbon::now()->format('d-m-Y')." | and today Settlement is ".$code.$dateCode,
                                'log_timestamp' => Carbon::now(),
                            ]);
                        } else {
                            echo "Wallet not found when trying to update settlement pending and the wallet is ".$stlPending->email;
                        }
                    }
                    $historySettleCashback = HistoryCashbackPending::where('settlement_status', 0)->get();
                    foreach($historySettleCashback as $cashbackHistory){
                        HistoryCashbackAdmin::create([
                            'id_invoice' => $cashbackHistory->id_invoice,
                            'nominal_terima_mdr' => $cashbackHistory->nominal_terima_mdr
                        ]);
                        $cashbackHistory->update([
                            'settlement_status' => 1
                        ]);
                    }
                }
                History::create([
                    'action' => 'Settlement Update Success | Periode : '.Carbon::now(),
                    'id_user' => NULL,
                    'email' => NULL,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                    'status' => 1
                ]);
                $settlement->status = 1;
                $settlement->save();
            } catch(Exception $e){
                echo $e;
                History::create([
                    'action' => 'Settlement Update Failed! '.Carbon::now(),
                    'id_user' => NULL,
                    'email' => NULL,
                    'lokasi_anda' => 'System Report',
                    'deteksi_ip' => 'System Report',
                    'log' => str_replace("'", "\'", json_encode(DB::getQueryLog()))."\n Error Record : ".$e,
                    'status' => 0
                ]);
                $settlement->status = 0;
                $settlement->save();
            }
        }
    }
}
