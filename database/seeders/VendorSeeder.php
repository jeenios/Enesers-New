<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'code' => 'VN0001',
                'state' => 'Active',
                'name' => '	QUALMEDI TECHNOLOGY CO.,LTD',
                'description' => 'Vendor penyedia perangkat IT',
                'email' => 'info@teknologi-nusantara.com',
                'website' => 'https://teknologi-nusantara.com',
                'payment_term_id' => 1,
                'vendor_category' => 'IT Supplier',
                'tax' => true,
                'tax_name' => 'PPN',
                'tax_number' => '01.234.567.8-999.000',
                'address' => json_encode([
                    'street' => 'Jl. Sudirman No. 10',
                    'city'   => 'Jakarta',
                    'country' => 'Indonesia'
                ]),
                'contact' => json_encode([
                    'phone' => '+62 812 3456 7890',
                    'fax'   => '+62 21 555 1234'
                ]),
                'payable_account' => '2010 - Hutang Usaha',
                'image' => json_encode([
                    'logo' => 'vendors/teknologi-nusantara.png'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'VN0002',
                'state' => 'Active',
                'name' => 'OXUS CO., LTD',
                'description' => 'Vendor penyedia bahan bangunan',
                'email' => 'contact@sumbermakmur.co.id',
                'website' => 'https://sumbermakmur.co.id',
                'payment_term_id' => 1,
                'vendor_category' => 'Construction',
                'tax' => false,
                'tax_name' => null,
                'tax_number' => null,
                'address' => json_encode([
                    'street' => 'Jl. Ahmad Yani No. 20',
                    'city'   => 'Bandung',
                    'country' => 'Indonesia'
                ]),
                'contact' => json_encode([
                    'phone' => '+62 811 9876 5432'
                ]),
                'payable_account' => '2010 - Hutang Usaha',
                'image' => json_encode([
                    'logo' => 'vendors/sumber-makmur.png'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
