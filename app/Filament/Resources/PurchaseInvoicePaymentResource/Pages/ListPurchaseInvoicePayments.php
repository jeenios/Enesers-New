<?php

namespace App\Filament\Resources\PurchaseInvoicePaymentResource\Pages;

use App\Filament\Resources\PurchaseInvoicePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoicePayments extends ListRecords
{
    protected static string $resource = PurchaseInvoicePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
