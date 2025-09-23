<?php

namespace App\Filament\Resources\IncomingBankPaymentResource\Pages;

use App\Filament\Resources\IncomingBankPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomingBankPayments extends ListRecords
{
    protected static string $resource = IncomingBankPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
