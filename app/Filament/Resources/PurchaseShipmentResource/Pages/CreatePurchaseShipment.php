<?php

namespace App\Filament\Resources\PurchaseShipmentResource\Pages;

use App\Filament\Resources\PurchaseShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseShipment extends CreateRecord
{
    protected static string $resource = PurchaseShipmentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
