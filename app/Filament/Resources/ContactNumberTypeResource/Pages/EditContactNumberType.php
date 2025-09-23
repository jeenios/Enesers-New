<?php

namespace App\Filament\Resources\ContactNumberTypeResource\Pages;

use App\Filament\Resources\ContactNumberTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactNumberType extends EditRecord
{
    protected static string $resource = ContactNumberTypeResource::class;

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
