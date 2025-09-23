<?php

namespace App\Filament\Resources\CashAdvanceReasonResource\Pages;

use App\Filament\Resources\CashAdvanceReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashAdvanceReasons extends ListRecords
{
    protected static string $resource = CashAdvanceReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
