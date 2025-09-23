<?php

namespace App\Filament\Resources\SalesPricelistResource\Pages;

use App\Filament\Resources\SalesPricelistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesPricelists extends ListRecords
{
    protected static string $resource = SalesPricelistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
