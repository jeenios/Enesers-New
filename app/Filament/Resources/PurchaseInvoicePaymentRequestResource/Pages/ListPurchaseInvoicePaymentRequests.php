<?php

namespace App\Filament\Resources\PurchaseInvoicePaymentRequestResource\Pages;

use App\Filament\Resources\PurchaseInvoicePaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoicePaymentRequests extends ListRecords
{
    protected static string $resource = PurchaseInvoicePaymentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
