<?php

namespace App\Filament\Resources\SalesEventResource\Pages;

use App\Filament\Resources\SalesEventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesEvent extends CreateRecord
{
    protected static string $resource = SalesEventResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
