<?php

namespace App\Filament\Resources\OutgoingBankFinancialResource\Pages;

use App\Filament\Resources\OutgoingBankFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutgoingBankFinancials extends ListRecords
{
    protected static string $resource = OutgoingBankFinancialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
