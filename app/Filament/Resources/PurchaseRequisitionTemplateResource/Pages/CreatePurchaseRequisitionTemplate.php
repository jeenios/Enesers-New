<?php

namespace App\Filament\Resources\PurchaseRequisitionTemplateResource\Pages;

use App\Filament\Resources\PurchaseRequisitionTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseRequisitionTemplate extends CreateRecord
{
    protected static string $resource = PurchaseRequisitionTemplateResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
