<?php

namespace App\Filament\Resources\SalesDownPaymentResource\Pages;

use App\Filament\Resources\SalesDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesDownPayments extends ListRecords
{
    protected static string $resource = SalesDownPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
