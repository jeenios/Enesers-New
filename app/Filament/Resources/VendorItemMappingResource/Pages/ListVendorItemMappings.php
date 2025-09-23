<?php

namespace App\Filament\Resources\VendorItemMappingResource\Pages;

use App\Filament\Resources\VendorItemMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorItemMappings extends ListRecords
{
    protected static string $resource = VendorItemMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
