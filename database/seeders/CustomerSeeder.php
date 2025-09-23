<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'code' => 'CUST-' . strtoupper(Str::random(6)),
                'state' => 'Active',
                'name' => 'PT Enesers Mitra',
                'description' => 'Perusahaan distributor alat kesehatan',
                'email' => 'info@enesers.com',
                'website' => 'https://enesers.com',
                'customer' => true,
                'payment_term_id' => 1,
                'user_id' => 1,
                'customer_category' => 'Corporate',
                'sales_pricelist_id' => 1,
                'credit_limit' => 100000000,
                'grace_period' => 10,
                'tax' => true,
                'tax_name' => 'PPN',
                'tax_number' => '01.234.567.8-901.000',
                'address' => json_encode([
                    'street' => 'Jl. Gatot Subroto No. 12',
                    'city' => 'Jakarta',
                    'province' => 'DKI Jakarta',
                    'country' => 'Indonesia',
                ]),
                'contact' => json_encode([
                    'phone' => '+62-21-555-1234',
                    'mobile' => '+62-812-3456-7890',
                ]),
                'receivable_account' => '1101-AR',
                'image' => json_encode([
                    'logo' => 'customers/enesers.png',
                ]),
            ],
            [
                'code' => 'CUST-' . strtoupper(Str::random(6)),
                'state' => 'Inactive',
                'name' => 'CV Sehat Selalu',
                'description' => 'Apotek dan penyedia obat',
                'email' => 'contact@sehatselalu.id',
                'website' => null,
                'customer' => true,
                'payment_term_id' => 1,
                'user_id' => null,
                'customer_category' => 'Retail',
                'sales_pricelist_id' => null,
                'credit_limit' => 50000000,
                'grace_period' => 5,
                'tax' => false,
                'tax_name' => null,
                'tax_number' => null,
                'address' => json_encode([
                    'street' => 'Jl. Merdeka No. 45',
                    'city' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'country' => 'Indonesia',
                ]),
                'contact' => json_encode([
                    'phone' => '+62-22-777-8888',
                ]),
                'receivable_account' => '1102-AR',
                'image' => json_encode([
                    'logo' => 'customers/sehatselalu.png',
                ]),
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
