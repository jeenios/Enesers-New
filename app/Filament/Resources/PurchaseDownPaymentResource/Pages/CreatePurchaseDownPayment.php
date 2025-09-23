<?php

namespace App\Filament\Resources\PurchaseDownPaymentResource\Pages;

use App\Filament\Resources\PurchaseDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseDownPayment extends CreateRecord
{
    protected static string $resource = PurchaseDownPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
