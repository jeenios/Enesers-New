<?php

namespace App\Filament\Resources\ItemBarcodeGeneratorResource\Pages;

use App\Filament\Resources\ItemBarcodeGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemBarcodeGenerators extends ListRecords
{
    protected static string $resource = ItemBarcodeGeneratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
