<?php

namespace App\Filament\Resources\PurchaseDownPaymentResource\Pages;

use App\Filament\Resources\PurchaseDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseDownPayments extends ListRecords
{
    protected static string $resource = PurchaseDownPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
