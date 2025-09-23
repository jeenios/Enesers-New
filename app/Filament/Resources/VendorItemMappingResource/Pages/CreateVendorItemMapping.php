<?php

namespace App\Filament\Resources\VendorItemMappingResource\Pages;

use App\Filament\Resources\VendorItemMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorItemMapping extends CreateRecord
{
    protected static string $resource = VendorItemMappingResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
