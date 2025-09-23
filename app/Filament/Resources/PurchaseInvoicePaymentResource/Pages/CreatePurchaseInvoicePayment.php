<?php

namespace App\Filament\Resources\PurchaseInvoicePaymentResource\Pages;

use App\Filament\Resources\PurchaseInvoicePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseInvoicePayment extends CreateRecord
{
    protected static string $resource = PurchaseInvoicePaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
