<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesPricelistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencyId = DB::table('currencies')->value('id');

        if (!$currencyId) {
            // kalau currencies masih kosong, isi minimal 1 dulu
            $currencyId = DB::table('currencies')->insertGetId([
                'code' => 'USD',
                'state' => 'Active',
                'name' => 'US Dollar',
                'rounding_precision' => '0.01',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('sales_pricelists')->insert([
            [
                'code' => 'SP0001',
                'state' => 'Active',
                'name' => 'Standard Pricelist',
                'description' => 'Default pricelist for sales',
                'currency_id' => $currencyId,
                'default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SP0002',
                'state' => 'Active',
                'name' => 'Wholesale Pricelist',
                'description' => 'Special prices for wholesale customers',
                'currency_id' => $currencyId,
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SP0003',
                'state' => 'Inactive',
                'name' => 'Promo Pricelist',
                'description' => 'Pricelist for promotional campaigns',
                'currency_id' => $currencyId,
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
