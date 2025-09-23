<?php

namespace App\Filament\Resources\OutgoingFinancialPaymentResource\Pages;

use App\Filament\Resources\OutgoingFinancialPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutgoingFinancialPayments extends ListRecords
{
    protected static string $resource = OutgoingFinancialPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
