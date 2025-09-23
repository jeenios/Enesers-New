<?php

namespace App\Filament\Resources\PurchaseInvoiceWriteOffResource\Pages;

use App\Filament\Resources\PurchaseInvoiceWriteOffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseInvoiceWriteOff extends EditRecord
{
    protected static string $resource = PurchaseInvoiceWriteOffResource::class;

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
