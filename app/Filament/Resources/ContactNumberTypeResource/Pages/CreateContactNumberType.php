<?php

namespace App\Filament\Resources\ContactNumberTypeResource\Pages;

use App\Filament\Resources\ContactNumberTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactNumberType extends CreateRecord
{
    protected static string $resource = ContactNumberTypeResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
