<?php

namespace App\Filament\Resources\OutgoingCashFinancialResource\Pages;

use App\Filament\Resources\OutgoingCashFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutgoingCashFinancial extends EditRecord
{
    protected static string $resource = OutgoingCashFinancialResource::class;

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
