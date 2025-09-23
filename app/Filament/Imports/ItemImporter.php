<?php

namespace App\Filament\Imports;

use App\Models\Item;
use App\Models\Unit;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('state')
                ->requiredMapping()
                ->rules(['required', 'in:Active,Inactive']),

            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required']),

            // Excel kolom "Unit" → nanti dikonversi ke unit_id
            ImportColumn::make('unit')
                ->label('Unit')
                ->rules(['required']),

            ImportColumn::make('item_type')
                ->label('Item Type'),

            ImportColumn::make('image'),

            ImportColumn::make('inventory_item')
                ->label('Inventory Item')
                ->boolean(),

            ImportColumn::make('sales_item')
                ->label('Sales Item')
                ->boolean(),

            ImportColumn::make('purchase_item')
                ->label('Purchase Item')
                ->boolean(),

            // Kolom Excel yang diabaikan (tidak akan dipakai untuk mapping)
            ImportColumn::make('created_at')
                ->label('Created At')
                ->optionalMapping(),

            ImportColumn::make('updated_at')
                ->label('Updated At')
                ->optionalMapping(),

            ImportColumn::make('current_approval_step')
                ->label('Current Approval Step')
                ->optionalMapping(),

            ImportColumn::make('current_approval_step_name')
                ->label('Current Approval Step Name')
                ->optionalMapping(),
        ];
    }

    public function resolveRecord(): ?Item
    {
        $data = $this->data;

        // Konversi "Unit" (name) → "unit_id"
        if (!empty($data['unit'])) {
            $unit = Unit::where('name', $data['unit'])->first();
            $data['unit_id'] = $unit?->id;
            unset($data['unit']); // hapus supaya tidak error kolom tidak ada
        }

        // Buang field Excel yang tidak dipakai
        unset($data['created_at'], $data['updated_at'], $data['current_approval_step'], $data['current_approval_step_name']);

        return new Item($data);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
