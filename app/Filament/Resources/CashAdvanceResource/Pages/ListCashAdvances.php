<?php

namespace App\Filament\Resources\CashAdvanceResource\Pages;

use App\Filament\Resources\CashAdvanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashAdvances extends ListRecords
{
    protected static string $resource = CashAdvanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
