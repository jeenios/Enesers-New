<?php

namespace App\Filament\Resources\PurchaseDownPaymentResource\Pages;

use App\Filament\Resources\PurchaseDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseDownPayment extends EditRecord
{
    protected static string $resource = PurchaseDownPaymentResource::class;

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
