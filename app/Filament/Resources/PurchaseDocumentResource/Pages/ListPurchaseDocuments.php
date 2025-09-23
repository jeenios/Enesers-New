<?php

namespace App\Filament\Resources\PurchaseDocumentResource\Pages;

use App\Filament\Resources\PurchaseDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseDocuments extends ListRecords
{
    protected static string $resource = PurchaseDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
