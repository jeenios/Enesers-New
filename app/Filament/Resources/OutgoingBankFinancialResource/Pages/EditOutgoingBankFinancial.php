<?php

namespace App\Filament\Resources\OutgoingBankFinancialResource\Pages;

use App\Filament\Resources\OutgoingBankFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutgoingBankFinancial extends EditRecord
{
    protected static string $resource = OutgoingBankFinancialResource::class;

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
