<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Discount;
use App\Models\DiscountMultiple;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        $discounts = [
            [
                'code' => 'DS0001',
                'state' => 'Active',
                'name' => '10%',
                'description' => 'Diskon reguler 10%',
                'multiples' => [
                    ['calculation' => 'percentage', 'value' => '10'],
                ],
            ],
            [
                'code' => 'DS0002',
                'state' => 'Active',
                'name' => '20%',
                'description' => 'Diskon 20%',
                'multiples' => [
                    ['calculation' => 'percentage', 'value' => '20'],
                ],
            ],
            [
                'code' => 'DS0003',
                'state' => 'Active',
                'name' => '25%',
                'description' => 'Diskon 25%',
                'multiples' => [
                    ['calculation' => 'percentage', 'value' => '25'],
                ],
            ],
            [
                'code' => 'DS0004',
                'state' => 'Inactive',
                'name' => 'Diskon Tidak Aktif',
                'description' => 'Diskon ini tidak aktif',
                'multiples' => [
                    ['calculation' => 'percentage', 'value' => '15'],
                ],
            ],
        ];

        foreach ($discounts as $disc) {
            $discount = Discount::create([
                'code' => $disc['code'],
                'state' => $disc['state'],
                'name' => $disc['name'],
                'description' => $disc['description'],
            ]);

            foreach ($disc['multiples'] as $multi) {
                DiscountMultiple::create([
                    'discount_id' => $discount->id,
                    'calculation' => $multi['calculation'],
                    'value' => $multi['value'],
                ]);
            }
        }
    }
}
