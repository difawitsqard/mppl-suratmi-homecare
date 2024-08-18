<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::factory(20)->recycle([
            OrderService::all(),
        ])->create();
    }
}
