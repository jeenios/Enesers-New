<?php

namespace App\Filament\Resources\IncomingCashPaymentResource\Pages;

use App\Filament\Resources\IncomingCashPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomingCashPayment extends EditRecord
{
    protected static string $resource = IncomingCashPaymentResource::class;

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
