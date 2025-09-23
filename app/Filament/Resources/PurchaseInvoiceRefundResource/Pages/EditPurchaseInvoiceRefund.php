<?php

namespace App\Filament\Resources\PurchaseInvoiceRefundResource\Pages;

use App\Filament\Resources\PurchaseInvoiceRefundResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseInvoiceRefund extends EditRecord
{
    protected static string $resource = PurchaseInvoiceRefundResource::class;

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
