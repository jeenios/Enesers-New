<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\FinancialAccount;
use App\Models\FinancialReason;
use App\Models\Hospital;
use App\Models\SalesPricelist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // CurrencySeeder::class,
            // UnitsSeeder::class,
            // PartnerCategorySeeder::class,
            // SalesPricelistSeeder::class,
            // PartnerSeeder::class,
            // WarehouseCategorySeeder::class,
            // WarehouseSeeder::class,
            // ItemCategorySeeder::class,
            // ItemSeeder::class,
            // CompanySeeder::class,
            // PaymentTermSeeder::class,
            // VendorSeeder::class,
            // DiscountSeeder::class,
            // CommissionSeeder::class,
            // BusinessUnitCategorySeeder::class,
            // BusinessUnitSeeder::class,
            // DeliveryMethodSeeder::class,
            // PurchaseRequisitionSeeder::class,
            // PurchaseRequisitionMultipleSeeder::class,
            // ExchangeRateSeeder::class,
            // PurchaseOrderSeeder::class,
            // PurchaseInvoiceSeeder::class,
            // ProjectCategorySeeder::class,
            // ProjectSeeder::class,
            // CustomerSeeder::class,
            // TaxSeeder::class,
            // HospitalSeeder::class,
            // FinancialAccountSeeder::class,
            // CashAdvanceReasonSeeder::class,
            // PaymentMethodSeeder::class,
            // FinancialReasonSeeder::class,
        ]);
    }
}
