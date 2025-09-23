<?php

namespace App\Filament\Resources\PurchaseQuotationResource\Pages;

use App\Filament\Resources\PurchaseQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseQuotation extends CreateRecord
{
    protected static string $resource = PurchaseQuotationResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
