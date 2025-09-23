<?php

namespace App\Filament\Resources\PurchaseDocumentResource\Pages;

use App\Filament\Resources\PurchaseDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseDocument extends CreateRecord
{
    protected static string $resource = PurchaseDocumentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
