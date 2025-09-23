<?php

namespace App\Filament\Resources\PurchaseInvoiceRefundResource\Pages;

use App\Filament\Resources\PurchaseInvoiceRefundResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseInvoiceRefund extends CreateRecord
{
    protected static string $resource = PurchaseInvoiceRefundResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
