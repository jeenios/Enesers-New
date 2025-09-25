<?php

namespace App\Filament\Resources\PurchaseInvoicePaymentRequestResource\Pages;

use App\Filament\Resources\PurchaseInvoicePaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseInvoicePaymentRequest extends EditRecord
{
    protected static string $resource = PurchaseInvoicePaymentRequestResource::class;

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
