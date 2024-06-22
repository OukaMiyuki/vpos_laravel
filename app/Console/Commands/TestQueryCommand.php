<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\History;
use App\Models\QrisWallet;
use App\Models\HistoryCashbackAdmin;
use App\Models\SettlementHstory;
use App\Models\SettlementPending;
use App\Models\HistoryCashbackPending;

class TestQueryCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-query-command';

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
        History::create([
            'action' => 'Settlement Update Success!',
            'id_user' => NULL,
            'email' => NULL,
            'lokasi_anda' => 'System Report',
            'deteksi_ip' => 'System Report',
            'log' => Carbon::now(),
            'status' => 1
        ]);
        // $settlementPending = SettlementPending::where('settlement_pending_status', 0)->get();
        // if(!is_null($settlementPending) || !empty($settlementPending)){
        //     foreach($settlementPending as $stlPending){
        //         $qrisWalletTenant = QrisWallet::where('id_user', $stlPending->id)->where('email', $stlPending->email)->first();
        //         if(!is_null($qrisWalletTenant) || empty($qrisWalletTenant)){
        //             echo "\n"."Qris tenant : ".$qrisWalletTenant->saldo."\n";
        //         }
        //     }

        //     $historySettleCashback = HistoryCashbackPending::where('settlement_status', 0)->get();
        //     foreach($historySettleCashback as $cashbackHistory){
        //         HistoryCashbackAdmin::create([
        //             'id_invoice' => $cashbackHistory->id_invoice,
        //             'nominal_terima_mdr' => $cashbackHistory->nominal_terima_mdr
        //         ]);
        //         $cashbackHistory->update([
        //             'settlement_status' => 1
        //         ]);
        //     }
        // }
    }
}
