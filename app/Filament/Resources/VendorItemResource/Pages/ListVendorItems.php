<?php

namespace App\Filament\Resources\VendorItemResource\Pages;

use App\Filament\Resources\VendorItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorItems extends ListRecords
{
    protected static string $resource = VendorItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
