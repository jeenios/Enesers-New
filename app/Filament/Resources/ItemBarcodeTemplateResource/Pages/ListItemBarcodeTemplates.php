<?php

namespace App\Filament\Resources\ItemBarcodeTemplateResource\Pages;

use App\Filament\Resources\ItemBarcodeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemBarcodeTemplates extends ListRecords
{
    protected static string $resource = ItemBarcodeTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
