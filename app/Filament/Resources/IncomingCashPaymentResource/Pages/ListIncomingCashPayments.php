<?php

namespace App\Filament\Resources\IncomingCashPaymentResource\Pages;

use App\Filament\Resources\IncomingCashPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomingCashPayments extends ListRecords
{
    protected static string $resource = IncomingCashPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
