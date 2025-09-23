<?php

namespace App\Filament\Resources\ItemBarcodeGeneratorResource\Pages;

use App\Filament\Resources\ItemBarcodeGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemBarcodeGenerator extends EditRecord
{
    protected static string $resource = ItemBarcodeGeneratorResource::class;

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
