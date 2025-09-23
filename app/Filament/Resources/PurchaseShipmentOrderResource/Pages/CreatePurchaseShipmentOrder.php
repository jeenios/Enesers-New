<?php

namespace App\Filament\Resources\PurchaseShipmentOrderResource\Pages;

use App\Filament\Resources\PurchaseShipmentOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseShipmentOrder extends CreateRecord
{
    protected static string $resource = PurchaseShipmentOrderResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
