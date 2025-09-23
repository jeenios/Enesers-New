<?php

namespace App\Filament\Resources\ManufactureOrderResource\Pages;

use App\Filament\Resources\ManufactureOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManufactureOrders extends ListRecords
{
    protected static string $resource = ManufactureOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
