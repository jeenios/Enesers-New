<?php

namespace App\Filament\Resources\VendorItemResource\Pages;

use App\Filament\Resources\VendorItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorItem extends EditRecord
{
    protected static string $resource = VendorItemResource::class;

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
