<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_methods')->insert([
            [
                'code' => 'DM-' . strtoupper(Str::random(5)),
                'state' => 'Active',
                'name' => 'Courier',
                'description' => 'Delivery via standard courier service',
            ],
            [
                'code' => 'DM-' . strtoupper(Str::random(5)),
                'state' => 'Active',
                'name' => 'Express',
                'description' => 'Delivery via express shipping',
            ],
            [
                'code' => 'DM-' . strtoupper(Str::random(5)),
                'state' => 'Inactive',
                'name' => 'Self Pickup',
                'description' => 'Customer picks up order directly',
            ],
        ]);
    }
}
