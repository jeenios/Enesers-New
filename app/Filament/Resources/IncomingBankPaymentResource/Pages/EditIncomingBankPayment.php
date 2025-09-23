<?php

namespace App\Filament\Resources\IncomingBankPaymentResource\Pages;

use App\Filament\Resources\IncomingBankPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomingBankPayment extends EditRecord
{
    protected static string $resource = IncomingBankPaymentResource::class;

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
