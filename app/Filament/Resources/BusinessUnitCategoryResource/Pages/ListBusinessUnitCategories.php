<?php

namespace App\Filament\Resources\BusinessUnitCategoryResource\Pages;

use App\Filament\Resources\BusinessUnitCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBusinessUnitCategories extends ListRecords
{
    protected static string $resource = BusinessUnitCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
