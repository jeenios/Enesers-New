<?php

namespace App\Filament\Resources\PurchaseShipmentOrderResource\Pages;

use App\Filament\Resources\PurchaseShipmentOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseShipmentOrders extends ListRecords
{
    protected static string $resource = PurchaseShipmentOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
