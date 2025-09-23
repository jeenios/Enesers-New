<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            [
                'code' => 'AUD',
                'state' => 'Active',
                'name' => 'Australian Dollar',
                'rounding_precision' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CNY',
                'state' => 'Active',
                'name' => 'Chinese Renminbi Yuan',
                'rounding_precision' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EUR',
                'state' => 'Active',
                'name' => 'Euro',
                'rounding_precision' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GBP',
                'state' => 'Active',
                'name' => 'British Pound',
                'rounding_precision' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IDR',
                'state' => 'Active',
                'name' => 'Indonesian Rupiah',
                'rounding_precision' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
