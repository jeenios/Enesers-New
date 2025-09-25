<?php

namespace App\Policies;

use App\Models\BillOfMaterial;
use App\Models\Customer;
use App\Models\Hospital;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\LandedCostComponent;
use App\Models\ManufactureOrder;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoicePayment;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseShipment;
use App\Models\User;
use App\Models\ResourceModel;
use App\Models\SalesDownPayment;
use App\Models\SalesOrder;
use App\Models\SalesQuotation;
use App\Models\StockAdjustment;
use App\Models\StockTake;
use App\Models\StockTransfer;
use App\Models\Vendor;
use App\Models\Warehouse;
use App\Models\WorkList;
use App\Models\WorkReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    /**
     * Admin bisa akses semua resource
     */
    public function before(User $user, $ability): ?bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
        return null;
    }

    protected function canAccess(User $user, $model): bool
    {
        $class = is_string($model) ? $model : get_class($model);

        if ($user->hasRole('Warehouse')) {
            $allowedModels = [
                Warehouse::class,
                StockAdjustment::class,
                StockTake::class,
                StockTransfer::class,
                BillOfMaterial::class,
                ManufactureOrder::class,
                PurchaseOrder::class,
                PurchaseShipment::class,
            ];

            if (in_array($class, $allowedModels)) {
                return true;
            }
        }

        if ($user->hasRole('Accounting')) {
            $allowedModels = [
                Vendor::class,
                Customer::class,
                Warehouse::class,
                LandedCostComponent::class,
                StockAdjustment::class,
                BillOfMaterial::class,
                PurchaseRequisition::class,
                PurchaseOrder::class,
                PurchaseShipment::class,
                PurchaseInvoice::class,
                PurchaseInvoicePayment::class,
                SalesDownPayment::class,
                SalesOrder::class,
                SalesQuotation::class,
            ];

            if (in_array($class, $allowedModels)) {
                return true;
            }
        }

        if ($user->hasRole('Aftersale')) {
            $allowedModels = [
                Item::class,
                ItemCategory::class,
                Hospital::class,
                WorkList::class,
                WorkReport::class,
            ];

            if (in_array($class, $allowedModels)) {
                return true;
            }
        }

        return false;
    }

    public function viewAny(User $user, string $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function view(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function create(User $user, string $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function update(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function delete(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }
}
