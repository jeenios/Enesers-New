<?php

namespace App\Filament\Resources\BusinessUnitCategoryResource\Pages;

use App\Filament\Resources\BusinessUnitCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBusinessUnitCategory extends CreateRecord
{
    protected static string $resource = BusinessUnitCategoryResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
