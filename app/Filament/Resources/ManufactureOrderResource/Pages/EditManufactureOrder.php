<?php

namespace App\Filament\Resources\ManufactureOrderResource\Pages;

use App\Filament\Resources\ManufactureOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManufactureOrder extends EditRecord
{
    protected static string $resource = ManufactureOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
