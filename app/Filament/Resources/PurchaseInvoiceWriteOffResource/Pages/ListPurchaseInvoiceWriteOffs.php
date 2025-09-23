<?php

namespace App\Filament\Resources\PurchaseInvoiceWriteOffResource\Pages;

use App\Filament\Resources\PurchaseInvoiceWriteOffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoiceWriteOffs extends ListRecords
{
    protected static string $resource = PurchaseInvoiceWriteOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
