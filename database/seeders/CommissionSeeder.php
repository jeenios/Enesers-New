<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commission;

class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        $commissions = [
            [
                'code' => 'CM0001',
                'state' => 'Active',
                'name' => 'Komisi Penjualan Produk',
                'description' => 'Komisi untuk setiap produk terjual',
                'value' => 5.0,
            ],
            [
                'code' => 'CM0002',
                'state' => 'Active',
                'name' => 'Komisi Distributor',
                'description' => 'Komisi untuk distributor resmi',
                'value' => 10.0,
            ],
            [
                'code' => 'CM0003',
                'state' => 'Active',
                'name' => 'Komisi Reseller',
                'description' => 'Komisi untuk reseller, saat ini non-aktif',
                'value' => 7.5,
            ],
        ];

        foreach ($commissions as $commission) {
            Commission::create($commission);
        }
    }
}
