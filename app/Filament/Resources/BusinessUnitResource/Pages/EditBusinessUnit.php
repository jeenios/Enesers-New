<?php

namespace App\Filament\Resources\BusinessUnitResource\Pages;

use App\Filament\Resources\BusinessUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessUnit extends EditRecord
{
    protected static string $resource = BusinessUnitResource::class;

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
