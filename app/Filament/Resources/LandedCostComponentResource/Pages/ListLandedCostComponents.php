<?php

namespace App\Filament\Resources\LandedCostComponentResource\Pages;

use App\Filament\Resources\LandedCostComponentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLandedCostComponents extends ListRecords
{
    protected static string $resource = LandedCostComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
