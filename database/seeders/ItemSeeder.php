<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan unit ada
        $unitId = DB::table('units')->value('id') ?? DB::table('units')->insertGetId([
            'code' => 'PCS',
            'state' => 'Active',
            'name' => 'Pieces',
            'symbol' => 'pcs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pastikan kategori ada
        $itemCategoryId = DB::table('item_categories')->value('id') ?? DB::table('item_categories')->insertGetId([
            'code' => 'GEN',
            'name' => 'General',
            'description' => 'General Item Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pastikan warehouse ada
        $warehouseId = DB::table('warehouses')->value('id') ?? DB::table('warehouses')->insertGetId([
            'code' => 'WH001',
            'state' => 'Active',
            'name' => 'Default Warehouse',
            'warehouse_category_id' => null,
            'warehouse_allow' => true,
            'description' => 'Auto generated warehouse',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('items')->insert([
            [
                'code' => 'IT0001',
                'state' => 'Active',
                'toggle' => true,
                'barcode' => '1234567890123',
                'name' => 'Motor Pump',
                'general_description' => '14 inch, 8GB RAM, 512GB SSD',
                'purchase_description' => 'Purchase for stock',
                'sales_description' => 'Sell to customers',
                'barcode_description' => 'EAN13 Barcode',
                'item_type' => 'Electronics',
                'unit_id' => $unitId,
                'initial_buy' => '500',
                'purchase_tax' => '10%',
                'sales_tax' => '10%',
                'item_category_id' => $itemCategoryId,
                'weight' => '2kg',
                'volume' => '0.03',
                'length' => '32',
                'width' => '22',
                'height' => '2',
                'sales_item' => true,
                'purchase_item' => true,
                'inventory_document' => 'INV001',
                'purchase_document' => 'PO001',
                'sales_document' => 'SO001',
                'accumulated_minimum_quantity' => '5',
                'accumulated_max_quantity' => '50',
                'default_minimum_quantity' => '2',
                'default_max_quantity' => '20',
                'warehouse_id' => $warehouseId,
                'minimum_quantity' => 2,
                'maximum_quantity' => 20,
                'sales_account' => '4101',
                'sales_return_account' => '4102',
                'sales_discount_account' => '4103',
                'sales_commision_account' => '4104',
                'sales_gross_account' => '4105',
                'purchase_account' => '5101',
                'purchase_return_account' => '5102',
                'inventory_account' => '1201',
                'cos_account' => '6101',
                'adjustment_increase_account' => '1202',
                'adjustment_decrease_account' => '1203',
                'inventory_usage_account' => '1204',
                'beginning_inventory_account' => '1205',
                'ending_inventory_account' => '1206',
                'purchase_alocation_account' => '5103',
                'work_inprogress_account' => '1501',
                'byproduct_account' => '1502',
                'image' => json_encode(['laptop.png']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IT0002',
                'state' => 'Active',
                'toggle' => false,
                'barcode' => '9876543210987',
                'name' => 'Fan',
                'general_description' => 'Wireless Mouse',
                'purchase_description' => 'Stock for peripherals',
                'sales_description' => 'Retail mouse for customers',
                'barcode_description' => 'EAN13 Barcode',
                'item_type' => 'Accessories',
                'unit_id' => $unitId,
                'initial_buy' => '100',
                'purchase_tax' => '10%',
                'sales_tax' => '10%',
                'item_category_id' => $itemCategoryId,
                'weight' => '200g',
                'volume' => '0.005',
                'length' => '10',
                'width' => '6',
                'height' => '3',
                'sales_item' => true,
                'purchase_item' => true,
                'inventory_document' => 'INV002',
                'purchase_document' => 'PO002',
                'sales_document' => 'SO002',
                'accumulated_minimum_quantity' => '10',
                'accumulated_max_quantity' => '200',
                'default_minimum_quantity' => '5',
                'default_max_quantity' => '100',
                'warehouse_id' => $warehouseId,
                'minimum_quantity' => 5,
                'maximum_quantity' => 100,
                'sales_account' => '4201',
                'sales_return_account' => '4202',
                'sales_discount_account' => '4203',
                'sales_commision_account' => '4204',
                'sales_gross_account' => '4205',
                'purchase_account' => '5201',
                'purchase_return_account' => '5202',
                'inventory_account' => '1301',
                'cos_account' => '6201',
                'adjustment_increase_account' => '1302',
                'adjustment_decrease_account' => '1303',
                'inventory_usage_account' => '1304',
                'beginning_inventory_account' => '1305',
                'ending_inventory_account' => '1306',
                'purchase_alocation_account' => '5203',
                'work_inprogress_account' => '1601',
                'byproduct_account' => '1602',
                'image' => json_encode(['mouse.png']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
