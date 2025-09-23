<?php

namespace App\Filament\Resources\BusinessUnitCategoryResource\Pages;

use App\Filament\Resources\BusinessUnitCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessUnitCategory extends EditRecord
{
    protected static string $resource = BusinessUnitCategoryResource::class;

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
