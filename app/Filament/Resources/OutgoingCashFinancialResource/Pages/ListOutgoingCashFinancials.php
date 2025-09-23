<?php

namespace App\Filament\Resources\OutgoingCashFinancialResource\Pages;

use App\Filament\Resources\OutgoingCashFinancialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutgoingCashFinancials extends ListRecords
{
    protected static string $resource = OutgoingCashFinancialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
