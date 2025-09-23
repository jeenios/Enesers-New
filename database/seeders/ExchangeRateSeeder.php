<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua currency dari tabel currencies
        $currencies = DB::table('currencies')->get();

        foreach ($currencies as $currency) {
            DB::table('exchange_rates')->insert([
                'state' => 'Active',
                'currency_id' => $currency->id,
                'rate' => 1,
                'effective_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
