<?php

namespace App\Filament\Resources\IncomingFinancialPaymentResource\Pages;

use App\Filament\Resources\IncomingFinancialPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomingFinancialPayments extends ListRecords
{
    protected static string $resource = IncomingFinancialPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
