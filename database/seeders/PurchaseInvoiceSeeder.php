<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $companyId        = DB::table('companies')->inRandomOrder()->value('id');
        $businessUnitId   = DB::table('business_units')->inRandomOrder()->value('id');
        $warehouseId      = DB::table('warehouses')->inRandomOrder()->value('id');
        $vendorId         = DB::table('vendors')->inRandomOrder()->value('id');
        $userId           = DB::table('users')->inRandomOrder()->value('id');
        $currencyId       = DB::table('currencies')->inRandomOrder()->value('id');
        $exchangeRateId   = DB::table('exchange_rates')->inRandomOrder()->value('id');
        $deliveryMethodId = DB::table('delivery_methods')->inRandomOrder()->value('id');

        foreach (range(1, 5) as $i) {
            DB::table('purchase_invoices')->insert([
                'code'                   => 'INV-' . Str::upper(Str::random(6)),
                'state'                  => fake()->randomElement(['Completed', 'Pending']),
                'company_id'             => $companyId,
                'bussiness_unit_id'      => $businessUnitId,
                'project_input'          => fake()->sentence(3),
                'item_type'              => fake()->randomElement(['Product', 'Service']),
                'is_part'                => fake()->boolean(),
                'tax_calculation'        => fake()->randomElement(['Inclusive', 'Exclusive']),
                'increase_stock'         => fake()->boolean(),
                'warehouse_id'           => $warehouseId,
                'vendor_id'              => $vendorId,
                'user_id'                => $userId,
                'currency_id'            => $currencyId,
                'exchange_rate_id'       => $exchangeRateId,
                'discount_calculation'   => fake()->word(),
                'rounding_amount'        => (string) fake()->numberBetween(0, 1000),
                'delivery_method_id'     => $deliveryMethodId,
                'reference'              => 'REF-' . Str::random(5),
                'description'            => fake()->sentence(),
                'payment_term'           => fake()->randomElement(['30 days', '60 days', '90 days']),
                'transaction_at'         => now()->subDays(rand(1, 10))->toDateString(),
                'due_at'                 => now()->addDays(rand(10, 30))->toDateString(),
                'delivery_at'            => now()->addDays(rand(5, 15))->toDateString(),
                'bank_account'           => fake()->bankAccountNumber(),

                'contact_person_name_shipment' => fake()->name(),
                'contact_person_phone_shipment' => fake()->phoneNumber(),
                'address_shipment'             => fake()->address(),
                'currency_shipment_id'         => $currencyId,
                'postcode_shipment'            => fake()->postcode(),

                'template_bill'       => fake()->word(),
                'address_bill'        => fake()->address(),
                'currency_bill_id'    => $currencyId,
                'postcode_bill'       => fake()->postcode(),

                'template_company'    => fake()->word(),
                'address_company'     => fake()->address(),
                'currency_company_id' => $currencyId,
                'postcode_company'    => fake()->postcode(),

                'template_from'             => fake()->word(),
                'contact_person_name_from'  => fake()->name(),
                'contact_person_phone_from' => fake()->phoneNumber(),
                'address_from'              => fake()->address(),
                'currency_from_id'          => $currencyId,
                'postcode_from'             => fake()->postcode(),

                'image'               => json_encode([fake()->imageUrl(640, 480, 'business', true)]),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}
