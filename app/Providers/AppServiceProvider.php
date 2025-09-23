<?php


namespace App\Providers;

use App\Models\BusinessUnit;
use App\Models\BusinessUnitCategory;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\DeliveryMethod;
use App\Models\Item;
use App\Models\LandedCostComponent;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\PurchaseRequisitionTemplate;
use App\Models\Resource;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorItem;
use App\Models\VendorItemMapping;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Warehouse;
use App\Models\WarehouseCategory;
use App\Observers\CrudObserver;
use App\Policies\BusinessUnitCategoryPolicy;
use App\Policies\BusinessUnitPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\CurrencyPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DeliveryMethodPolicy;
use App\Policies\LandedCostComponentPolicy;
use App\Policies\PartnerCategoryPolicy;
use App\Policies\PartnerPolicy;
use App\Policies\PurchaseRequisitionTemplatePolicy;
use App\Policies\ResourcePolicy;
use App\Policies\RolePolicy;
use App\Policies\UnitPolicy;
use App\Policies\VendorItemMappingPolicy;
use App\Policies\VendorItemPolicy;
use App\Policies\VendorPolicy;
use App\Policies\WarehousePolicy;
use App\Policies\WarehouseCategoryPolicy;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        // Role::class => RolePolicy::class,
        Resource::class => ResourcePolicy::class,
    ];

    public function boot(): void
    {
        $modelFiles = File::files(app_path('Models'));

        foreach ($modelFiles as $file) {
            $class = 'App\\Models\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);

            if (class_exists($class)) {
                $class::observe(CrudObserver::class);
            }
        }
    }
}
