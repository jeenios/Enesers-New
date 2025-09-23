<?php

namespace App\Filament\Resources\PurchaseInvoiceWriteOffResource\Pages;

use App\Filament\Resources\PurchaseInvoiceWriteOffResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseInvoiceWriteOff extends CreateRecord
{
    protected static string $resource = PurchaseInvoiceWriteOffResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
