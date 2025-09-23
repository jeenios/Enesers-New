<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryId = DB::table('warehouse_categories')->value('id') ?? DB::table('warehouse_categories')->insertGetId([
            'code' => 'DEFAULT',
            'name' => 'Default Category',
            'description' => 'Auto created warehouse category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('warehouses')->insert([
            [
                'code' => 'WH0001',
                'state' => 'Active',
                'name' => 'Main Warehouse',
                'warehouse_category_id' => $categoryId,
                'warehouse_allow' => true,
                'description' => 'Main central warehouse for storing goods',
                'address_type' => 'Head Office',
                'contact_person_name' => 'Budi Santoso',
                'contact_person_phone' => '+62-81234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'country_code' => 'ID',
                'postcode' => '10110',
                'sales_account' => '4101',
                'sales_return_account' => '4102',
                'sales_discount_account' => '4103',
                'sales_commission_account' => '4104',
                'sales_gross_account' => '4105',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WH0002',
                'state' => 'Active',
                'name' => 'Finished Goods Warehouse',
                'warehouse_category_id' => $categoryId,
                'warehouse_allow' => true,
                'description' => 'Warehouse for finished products ready for distribution',
                'address_type' => 'Branch',
                'contact_person_name' => 'Siti Aminah',
                'contact_person_phone' => '+62-81345678901',
                'address' => 'Jl. Industri No. 25, Bandung',
                'country_code' => 'ID',
                'postcode' => '40256',
                'sales_account' => '4201',
                'sales_return_account' => '4202',
                'sales_discount_account' => '4203',
                'sales_commission_account' => '4204',
                'sales_gross_account' => '4205',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WH0003',
                'state' => 'Inactive',
                'name' => 'Old Spare Parts Warehouse',
                'warehouse_category_id' => $categoryId,
                'warehouse_allow' => false,
                'description' => 'Warehouse for obsolete spare parts',
                'address_type' => 'Branch',
                'contact_person_name' => 'Andi Wijaya',
                'contact_person_phone' => '+62-81456789012',
                'address' => 'Jl. Raya Barat No. 50, Surabaya',
                'country_code' => 'ID',
                'postcode' => '60123',
                'sales_account' => '4301',
                'sales_return_account' => '4302',
                'sales_discount_account' => '4303',
                'sales_commission_account' => '4304',
                'sales_gross_account' => '4305',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
