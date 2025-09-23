<?php

namespace App\Filament\Resources\ItemBarcodeTemplateResource\Pages;

use App\Filament\Resources\ItemBarcodeTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemBarcodeTemplate extends EditRecord
{
    protected static string $resource = ItemBarcodeTemplateResource::class;

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
