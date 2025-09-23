<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->value('id') ?? DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $partnerCategoryId = DB::table('partner_categories')->value('id') ?? DB::table('partner_categories')->insertGetId([
            'code' => 'CUS',
            'name' => 'Customer',
            'description' => 'Default customer category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pricelistId = DB::table('sales_pricelists')->value('id') ?? DB::table('sales_pricelists')->insertGetId([
            'code' => 'STD',
            'state' => 'Active',
            'name' => 'Standard Pricelist',
            'description' => 'Default sales pricelist',
            'currency_id' => DB::table('currencies')->value('id') ?? DB::table('currencies')->insertGetId([
                'code' => 'USD',
                'state' => 'Active',
                'name' => 'US Dollar',
                'rounding_precision' => '0.01',
                'created_at' => now(),
                'updated_at' => now(),
            ]),
            'default' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('partners')->insert([
            [
                'code' => 'PA0001',
                'state' => 'Active',
                'name' => 'TONGYE TECHNOLOGIES DEVELOPMENT CO., LTD',
                'description' => 'Main customer partner',
                'email' => 'contact@majunjaya.com',
                'website' => 'https://majunjaya.com',
                'customer' => true,
                'customer_payment_term' => '30 Days',
                'user_id' => $userId,
                'vendor' => false,
                'vendor_payment_term' => null,
                'partner_category_id' => $partnerCategoryId,
                'sales_pricelist_id' => $pricelistId,
                'tax' => true,
                'tax_name' => 'PPN',
                'tax_number' => '01.234.567.8-999.000',
                'receivable_account' => '1101',
                'payable_account' => null,
                'image' => json_encode(['logo.png']),
                'contact' => json_encode(['+62-8123456789']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PA0002',
                'state' => 'Active',
                'name' => 'PT. COMEN BIOMEDICAL INDONESIA',
                'description' => 'Main vendor partner',
                'email' => 'sales@suppliermakmur.com',
                'website' => 'https://suppliermakmur.com',
                'customer' => false,
                'customer_payment_term' => null,
                'user_id' => $userId,
                'vendor' => true,
                'vendor_payment_term' => '45 Days',
                'partner_category_id' => $partnerCategoryId,
                'sales_pricelist_id' => $pricelistId,
                'tax' => false,
                'tax_name' => null,
                'tax_number' => null,
                'receivable_account' => null,
                'payable_account' => '2101',
                'image' => json_encode(['vendor.png']),
                'contact' => json_encode(['+62-811223344']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
