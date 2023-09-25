<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class statusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status active to inactive when expire date is over';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //

        // DB::table('sales')->whereRaw('expire_date', '<', date('Y-m-d'))->update(['active' => 0]);
        // $change = Sale::where('active', true)->where('expire_date', '<', now())->update(['active' => false]); //Latest
        // echo "Status change succesfully";

    }
}
