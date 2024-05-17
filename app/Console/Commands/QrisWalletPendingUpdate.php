<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\QrisWallet;
use App\Models\QrisWalletPending;
use App\Models\StoreDetail;

class QrisWalletPendingUpdate extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:qris-wallet-pending-update';

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
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $invoiceYesterday = Invoice::select([
                                        'id_tenant',
                                        'email',
                                        "store_identifier",
                                        DB::raw("(sum(nominal_bayar)) as total_penghasilan"),
                                ])
                                ->whereDate('tanggal_transaksi', $yesterday)
                                ->groupBy(['store_identifier', 'email', 'id_tenant'])
                                ->get();
        foreach($invoiceYesterday as $invoice){
            $qris = QrisWallet::where('id_user', $invoice->id_tenant)
                                ->where('email', $invoice->email)
                                ->first();
            $qrisSaldo = $qris->saldo;
            $saldoTransfer = $invoice->total_penghasilan;
            $qris->update([
                'saldo' => $qrisSaldo+$saldoTransfer
            ]);
        }
    }
}
