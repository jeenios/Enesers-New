<?php

namespace App\Filament\Resources\PurchaseShipmentOrderResource\Pages;

use App\Filament\Resources\PurchaseShipmentOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseShipmentOrder extends EditRecord
{
    protected static string $resource = PurchaseShipmentOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
