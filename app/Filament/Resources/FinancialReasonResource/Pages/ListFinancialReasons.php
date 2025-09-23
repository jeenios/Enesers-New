<?php

namespace App\Filament\Resources\FinancialReasonResource\Pages;

use App\Filament\Resources\FinancialReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialReasons extends ListRecords
{
    protected static string $resource = FinancialReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
