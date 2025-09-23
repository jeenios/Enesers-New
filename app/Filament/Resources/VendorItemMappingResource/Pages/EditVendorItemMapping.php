<?php

namespace App\Filament\Resources\VendorItemMappingResource\Pages;

use App\Filament\Resources\VendorItemMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorItemMapping extends EditRecord
{
    protected static string $resource = VendorItemMappingResource::class;

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
