<?php

namespace App\Filament\Resources\PurchaseInvoicePaymentResource\Pages;

use App\Filament\Resources\PurchaseInvoicePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseInvoicePayment extends EditRecord
{
    protected static string $resource = PurchaseInvoicePaymentResource::class;

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
