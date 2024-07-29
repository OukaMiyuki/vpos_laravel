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


class RunSettlementPendingManual extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:run-settlement-pending-manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $settlement = Settlement::whereDate('tanggal_settlement', Carbon::now())->first();
        $settlementPending = SettlementPending::where('settlement_pending_status', 0)->get();
        if(!is_null($settlementPending) || !empty($settlementPending)){
            foreach($settlementPending as $stlPending){
                $qrisWalletTenant = QrisWallet::where('email', $stlPending->email)->first();
                if(!is_null($qrisWalletTenant) || empty($qrisWalletTenant)){
                    $saldoQrisTenant = $qrisWalletTenant->saldo;
                    if(!is_null($saldoQrisTenant) || !empty($saldoQrisTenant)){
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
                            'action' => "Settlement pending for ".$stlPending->nomor_settlement_pending." | has been settled on".Carbon::now()->format('d-m-Y')." | and today Settlement is ".$settlement->nomor_settlement,
                            'log_timestamp' => Carbon::now(),
                        ]);
                        echo "Pending Settlement Settled - User Email : ".$stlPending->email." | ".$stlPending->nominal_settle." | Periode : ".Carbon::now()."\n";
                    } else {
                        echo "THis Wallet is NULL : ".$qrisWalletTenant;
                    }
                } else {
                    echo "Wallet not found when trying to update settlement pending and the wallet is ".$stlPending->email;
                }
            }
            $historySettleCashback = HistoryCashbackPending::where('settlement_status', 0)->get();
            foreach($historySettleCashback as $cashbackHistory){
                HistoryCashbackAdmin::create([
                    'id_invoice' => $cashbackHistory->id_invoice,
                    'nominal_terima_mdr' => $cashbackHistory->nominal_terima_mdr,
                    'periode_transaksi' => $cashbackHistory->periode_transaksi,
                ]);
                $cashbackHistory->update([
                    'settlement_status' => 1
                ]);
            }
        }
    }
}
