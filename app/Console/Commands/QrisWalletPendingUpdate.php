<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\QrisWallet;
use App\Models\HistoryCashbackAdmin;
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
                                    'id',
                                    'id_tenant',
                                    'email',
                                    "store_identifier",
                                    DB::raw("(sum(nominal_mdr)) as total_nominal_mdr"),
                                    DB::raw("(sum(nominal_terima_bersih)) as total_penghasilan"),
                            ])
                            ->whereDate('tanggal_transaksi', $yesterday)
                            ->where('jenis_pembayaran', 'Qris')
                            ->where('status_pembayaran', 1)
                            ->groupBy(['id','store_identifier', 'email', 'id_tenant'])
                            ->get();
        foreach($invoiceYesterday as $invoice){
            $qris = QrisWallet::where('id_user', $invoice->id_tenant)->where('email', $invoice->email)->first();
            $qrisSaldo = $qris->saldo;
            $saldoTransfer = $invoice->total_penghasilan;
            $qris->update([
                'saldo' => $qrisSaldo+$saldoTransfer
            ]);
            $qrisAdminWallet = QrisWallet::where('id_user', 1)->where('email', 'adminsu@visipos.id')->find(1);
            $saldoAdmin = $qrisAdminWallet->saldo;
            $nominal_mdr = $invoice->total_nominal_mdr;
            $insentif_cashback = $nominal_mdr*0.25;

            $qrisAdminWallet->update([
                'saldo' => $saldoAdmin+$insentif_cashback
            ]);

            HistoryCashbackAdmin::create([
                'id_invoice' => $invoice->id,
                'nominal_terima_mdr' => $insentif_cashback
            ]);
        }
    }
}
