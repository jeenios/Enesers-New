<?php

namespace App\Filament\Resources\ItemSalesPriceEntryResource\Pages;

use App\Filament\Resources\ItemSalesPriceEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemSalesPriceEntries extends ListRecords
{
    protected static string $resource = ItemSalesPriceEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
