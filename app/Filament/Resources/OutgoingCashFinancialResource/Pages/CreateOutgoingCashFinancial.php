<?php

namespace App\Filament\Resources\OutgoingCashFinancialResource\Pages;

use App\Filament\Resources\OutgoingCashFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOutgoingCashFinancial extends CreateRecord
{
    protected static string $resource = OutgoingCashFinancialResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
