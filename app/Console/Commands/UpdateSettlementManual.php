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

class UpdateSettlementManual extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateWallet:update-settlement-manual';

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
        $tenantinvoice = Tenant::with([
                                        'invoice' => function($query){
                                            $query->where('settlement_status', 0)
                                                ->where('jenis_pembayaran', 'Qris')
                                                ->where('status_pembayaran', 1)
                                                ->whereDate('tanggal_transaksi', '2024-06-20');
                                        }
                                    ])
                                    ->get();

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
                    'email' => $sumInvoice->email,
                    'settlement_time_stamp' => '2024-06-21 15:01:40',
                    'nominal_settle' => $totalSumFloor,
                    'nominal_insentif_cashback' => $totalCashback
                ]);
            } else {
                echo "Wallet not found".$sumInvoice->email;
            }
        }
    }
}
