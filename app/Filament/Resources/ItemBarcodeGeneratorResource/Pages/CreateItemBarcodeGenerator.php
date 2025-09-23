<?php

namespace App\Filament\Resources\ItemBarcodeGeneratorResource\Pages;

use App\Filament\Resources\ItemBarcodeGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItemBarcodeGenerator extends CreateRecord
{
    protected static string $resource = ItemBarcodeGeneratorResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
