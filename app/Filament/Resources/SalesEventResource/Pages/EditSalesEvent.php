<?php

namespace App\Filament\Resources\SalesEventResource\Pages;

use App\Filament\Resources\SalesEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesEvent extends EditRecord
{
    protected static string $resource = SalesEventResource::class;

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
