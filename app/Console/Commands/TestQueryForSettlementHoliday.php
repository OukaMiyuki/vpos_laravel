<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\SettlementDateSetting;

class TestQueryForSettlementHoliday extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-query-holiday';

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
        $now = date('Y-m-d');
        $now=date('Y-m-d', strtotime($now));
        $settlementDate = SettlementDateSetting::latest()->get();
        $dateCollection = 0;
        foreach($settlementDate as $settlement){
            $startDate = date('Y-m-d', strtotime($settlement->stat_date));
            $endDate = date('Y-m-d', strtotime($settlement->end_date));
            if (($now >= $startDate) && ($now <= $endDate)) {
                $dateCollection+=1;
                echo "\n Hari ".$settlement->stat_date." | ".$settlement->end_date."\n";
            }
        }

        echo "\n Hasilnya : ".$dateCollection."\n";
    }
}
