<?php

namespace App\Filament\Resources\SalesEventResource\Pages;

use App\Filament\Resources\SalesEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesEvents extends ListRecords
{
    protected static string $resource = SalesEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
