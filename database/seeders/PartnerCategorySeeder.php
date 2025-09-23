<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partner_categories')->insert([
            [
                'code' => 'PC0001',
                'parent_category' => null,
                'name' => 'Supplier',
                'description' => 'Partner that supplies products or services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PC0002',
                'parent_category' => null,
                'name' => 'Customer',
                'description' => 'Partner that purchases goods or services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PC0003',
                'parent_category' => null,
                'name' => 'Vendor',
                'description' => 'Third-party vendor partners',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PC0004',
                'parent_category' => 'SUP',
                'name' => 'Distributor',
                'description' => 'Distributor under Supplier category',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
