<?php

namespace App\Console\Commands;

use App\Models\OrderService;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class updateExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pending orders to canceled if booking date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $affectedRows = OrderService::where('status', 'pending')
            ->where('date', '<', Carbon::now())
            ->update(['status' => 'canceled']);

        $this->info("Updated {$affectedRows} orders.");
    }
}
