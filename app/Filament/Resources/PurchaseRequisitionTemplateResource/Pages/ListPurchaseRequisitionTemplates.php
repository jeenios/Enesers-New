<?php

namespace App\Filament\Resources\PurchaseRequisitionTemplateResource\Pages;

use App\Filament\Resources\PurchaseRequisitionTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseRequisitionTemplates extends ListRecords
{
    protected static string $resource = PurchaseRequisitionTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
