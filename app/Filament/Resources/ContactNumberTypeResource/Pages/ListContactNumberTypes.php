<?php

namespace App\Filament\Resources\ContactNumberTypeResource\Pages;

use App\Filament\Resources\ContactNumberTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactNumberTypes extends ListRecords
{
    protected static string $resource = ContactNumberTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
