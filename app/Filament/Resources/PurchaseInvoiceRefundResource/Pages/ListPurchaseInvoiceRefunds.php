<?php

namespace App\Filament\Resources\PurchaseInvoiceRefundResource\Pages;

use App\Filament\Resources\PurchaseInvoiceRefundResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoiceRefunds extends ListRecords
{
    protected static string $resource = PurchaseInvoiceRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
