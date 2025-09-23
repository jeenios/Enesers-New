<?php

namespace App\Filament\Resources\ItemSalesPriceEntryResource\Pages;

use App\Filament\Resources\ItemSalesPriceEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemSalesPriceEntry extends EditRecord
{
    protected static string $resource = ItemSalesPriceEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
