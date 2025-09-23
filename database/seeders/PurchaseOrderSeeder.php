<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderMultiple;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        // contoh ambil id dari tabel referensi (pastikan sudah ada datanya)
        $companyId       = DB::table('companies')->value('id');
        $businessUnitId  = DB::table('business_units')->value('id');
        $warehouseId     = DB::table('warehouses')->value('id');
        $vendorId        = DB::table('vendors')->value('id');
        $userId          = DB::table('users')->value('id');
        $currencyId      = DB::table('currencies')->value('id');
        $exchangeRateId  = DB::table('exchange_rates')->value('id');
        $deliveryMethodId = DB::table('delivery_methods')->value('id');

        $unitId          = DB::table('units')->value('id');
        $itemId          = DB::table('items')->value('id');
        $discountId      = DB::table('discounts')->value('id');
        $taxId           = DB::table('taxes')->value('id');

        // Insert Purchase Order
        $purchaseOrder = PurchaseOrder::create([
            'code'                     => 'PO-' . strtoupper(Str::random(6)),
            'state'                    => 'Completed',
            'company_id'               => $companyId,
            'bussiness_unit_id'        => $businessUnitId,
            'project_input'            => 'Project Test',
            'item_type'                => 'General',
            'tax_calculation'          => 'Include',
            'warehouse_id'             => $warehouseId,
            'vendor_id'                => $vendorId,
            'user_id'                  => $userId,
            'currency_id'              => $currencyId,
            'exchange_rate_id'         => $exchangeRateId,
            'discount_calculation'     => 'Percent',
            'rounding_amount'          => '0',
            'delivery_method_id'       => $deliveryMethodId,
            'reference'                => 'REF-001',
            'description'              => 'Seeder Purchase Order',
            'payment_term'             => '30 Days',
            'transaction_at'           => now()->toDateTimeString(),
            'estimate_at'              => now()->addDays(7)->toDateTimeString(),
            'contact_person_name_shipment'  => 'John Doe',
            'contact_person_phone_shipment' => '081234567890',
            'address_shipment'              => 'Jl. Raya Shipment 123',
            'currency_shipment_id'          => $currencyId,
            'postcode_shipment'             => '15314',
            'template_bill'                 => 'Default',
            'address_bill'                  => 'Jl. Raya Billing 123',
            'currency_bill_id'              => $currencyId,
            'postcode_bill'                 => '15315',
            'template_company'              => 'Default',
            'address_company'               => 'Jl. Raya Company 123',
            'currency_company_id'           => $currencyId,
            'postcode_company'              => '15316',
            'template_from'                 => 'Default',
            'contact_person_name_from'      => 'Jane Doe',
            'contact_person_phone_from'     => '089876543210',
            'address_from'                  => 'Jl. Raya From 123',
            'currency_from_id'              => $currencyId,
            'postcode_from'                 => '15317',
            'purchase_requisition_id'       => null,
            'image'                         => json_encode([]),
        ]);

        // Insert beberapa item ke Purchase Order Multiple
        for ($i = 1; $i <= 3; $i++) {
            PurchaseOrderMultiple::create([
                'purchase_order_id'          => $purchaseOrder->id,
                'purchase_order_multiple_id' => null,
                'item_id'                    => $itemId,
                'description'                => "Item {$i} description",
                'quantity'                   => rand(1, 10),
                'price'                      => rand(10000, 50000),
                'toggle_discount'            => false,
                'unit_id'                    => $unitId,
                'discount_id'                => $discountId,
                'tax_id'                     => $taxId,
            ]);
        }
    }
}
