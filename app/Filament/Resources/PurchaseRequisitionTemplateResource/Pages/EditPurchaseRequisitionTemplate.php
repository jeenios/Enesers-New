<?php

namespace App\Filament\Resources\PurchaseRequisitionTemplateResource\Pages;

use App\Filament\Resources\PurchaseRequisitionTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseRequisitionTemplate extends EditRecord
{
    protected static string $resource = PurchaseRequisitionTemplateResource::class;

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
