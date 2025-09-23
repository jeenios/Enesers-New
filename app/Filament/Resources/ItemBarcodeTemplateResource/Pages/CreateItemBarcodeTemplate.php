<?php

namespace App\Filament\Resources\ItemBarcodeTemplateResource\Pages;

use App\Filament\Resources\ItemBarcodeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItemBarcodeTemplate extends CreateRecord
{
    protected static string $resource = ItemBarcodeTemplateResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
