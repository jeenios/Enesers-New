<?php

namespace App\Filament\Resources\ItemSalesPriceEntryResource\Pages;

use App\Filament\Resources\ItemSalesPriceEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItemSalesPriceEntry extends CreateRecord
{
    protected static string $resource = ItemSalesPriceEntryResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
