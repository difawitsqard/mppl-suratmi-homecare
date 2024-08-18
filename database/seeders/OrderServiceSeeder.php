<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderService::factory(50)->recycle([
            User::role('customer')->get(),
            Service::all(),
        ])->create();
    }
}
