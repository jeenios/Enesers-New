<?php

namespace App\Filament\Resources\PurchaseShipmentResource\Pages;

use App\Filament\Resources\PurchaseShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseShipment extends EditRecord
{
    protected static string $resource = PurchaseShipmentResource::class;

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
