<?php

namespace App\Filament\Exports;

use App\Models\Item;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ItemExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Code'),
            ExportColumn::make('state')->label('State'),
            ExportColumn::make('toggle')->label('Toggle'),
            ExportColumn::make('barcode')->label('Barcode'),
            ExportColumn::make('name')->label('Name'),
            ExportColumn::make('general_description')->label('General Description'),
            ExportColumn::make('purchase_description')->label('Purchase Description'),
            ExportColumn::make('sales_description')->label('Sales Description'),
            ExportColumn::make('barcode_description')->label('Barcode Description'),
            ExportColumn::make('item_type')->label('Item Type'),
            ExportColumn::make('unit.name')->label('Unit'),
            ExportColumn::make('initial_buy')->label('Initial Buy'),
            ExportColumn::make('purchase_tax')->label('Purchase Tax'),
            ExportColumn::make('sales_tax')->label('Sales Tax'),
            ExportColumn::make('itemCategory.name')->label('Item Category'),
            ExportColumn::make('weight')->label('Weight'),
            ExportColumn::make('volume')->label('Volume'),
            ExportColumn::make('length')->label('Length'),
            ExportColumn::make('width')->label('Width'),
            ExportColumn::make('height')->label('Height'),
            ExportColumn::make('sales_item')->label('Sales Item'),
            ExportColumn::make('purchase_item')->label('Purchase Item'),
            ExportColumn::make('inventory_document')->label('Inventory Document'),
            ExportColumn::make('purchase_document')->label('Purchase Document'),
            ExportColumn::make('sales_document')->label('Sales Document'),
            ExportColumn::make('accumulated_minimum_quantity')->label('Accumulated Min Qty'),
            ExportColumn::make('accumulated_max_quantity')->label('Accumulated Max Qty'),
            ExportColumn::make('default_minimum_quantity')->label('Default Min Qty'),
            ExportColumn::make('default_max_quantity')->label('Default Max Qty'),
            ExportColumn::make('warehouse.name')->label('Warehouse'),
            ExportColumn::make('minimum_quantity')->label('Min Qty'),
            ExportColumn::make('maximum_quantity')->label('Max Qty'),
            ExportColumn::make('sales_account')->label('Sales Account'),
            ExportColumn::make('sales_return_account')->label('Sales Return Account'),
            ExportColumn::make('sales_discount_account')->label('Sales Discount Account'),
            ExportColumn::make('sales_commision_account')->label('Sales Commision Account'),
            ExportColumn::make('sales_gross_account')->label('Sales Gross Account'),
            ExportColumn::make('purchase_account')->label('Purchase Account'),
            ExportColumn::make('purchase_return_account')->label('Purchase Return Account'),
            ExportColumn::make('inventory_account')->label('Inventory Account'),
            ExportColumn::make('cos_account')->label('COS Account'),
            ExportColumn::make('adjustment_increase_account')->label('Adjustment Increase Account'),
            ExportColumn::make('adjustment_decrease_account')->label('Adjustment Decrease Account'),
            ExportColumn::make('inventory_usage_account')->label('Inventory Usage Account'),
            ExportColumn::make('beginning_inventory_account')->label('Beginning Inventory Account'),
            ExportColumn::make('ending_inventory_account')->label('Ending Inventory Account'),
            ExportColumn::make('purchase_alocation_account')->label('Purchase Allocation Account'),
            ExportColumn::make('work_inprogress_account')->label('Work In Progress Account'),
            ExportColumn::make('byproduct_account')->label('Byproduct Account'),
            ExportColumn::make('image')->label('Images'),
            ExportColumn::make('created_at')->label('Created At'),
            ExportColumn::make('updated_at')->label('Updated At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
