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
                                                ->whereDate('tanggal_transaksi', '2024-06-15');
                                        }
                                    ])
                                    ->get();
        echo "walla";
        foreach($tenantinvoice as $sumInvoice){
            foreach($sumInvoice->invoice as $invoice){
                echo $invoice->nomor_invoice."\n";
            }
        }
    }
}
