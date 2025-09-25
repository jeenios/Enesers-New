<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('taxes')->insert([
            [
                'code' => 'TAX-01',
                'state' => 'Active',
                'name' => 'PPN 11%',
                'description' => 'Pajak Pertambahan Nilai 11%',
                'value' => 11.0,
                'tax_type' => 'VAT',
                'purchase_tax_account' => '2110',
                'sales_tax_account' => '4110',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TAX-02',
                'state' => 'Active',
                'name' => 'PPH 23',
                'description' => 'Pajak Penghasilan Pasal 23',
                'value' => 2.0,
                'tax_type' => 'Income Tax',
                'purchase_tax_account' => '2120',
                'sales_tax_account' => '4120',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TAX-03',
                'state' => 'Active',
                'name' => 'PPN 10%',
                'description' => 'Pajak Pertambahan Nilai lama 10%',
                'value' => 10.0,
                'tax_type' => 'VAT',
                'purchase_tax_account' => '2130',
                'sales_tax_account' => '4130',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
