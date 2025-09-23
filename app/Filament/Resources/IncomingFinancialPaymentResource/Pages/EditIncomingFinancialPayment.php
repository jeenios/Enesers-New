<?php

namespace App\Filament\Resources\IncomingFinancialPaymentResource\Pages;

use App\Filament\Resources\IncomingFinancialPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomingFinancialPayment extends EditRecord
{
    protected static string $resource = IncomingFinancialPaymentResource::class;

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
