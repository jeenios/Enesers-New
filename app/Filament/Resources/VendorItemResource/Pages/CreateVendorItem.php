<?php

namespace App\Filament\Resources\VendorItemResource\Pages;

use App\Filament\Resources\VendorItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorItem extends CreateRecord
{
    protected static string $resource = VendorItemResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
