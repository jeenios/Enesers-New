<?php

namespace App\Filament\Resources\OutgoingBankFinancialResource\Pages;

use App\Filament\Resources\OutgoingBankFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOutgoingBankFinancial extends CreateRecord
{
    protected static string $resource = OutgoingBankFinancialResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
