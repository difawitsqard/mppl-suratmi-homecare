<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\updateExpiredOrders;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('orders:update-pending', function () {
    // Panggil command Anda di sini
    $this->call(updateExpiredOrders::class);
})->describe('Update pending orders');
