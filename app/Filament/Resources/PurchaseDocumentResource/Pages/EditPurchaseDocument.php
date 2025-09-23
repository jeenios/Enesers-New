<?php

namespace App\Filament\Resources\PurchaseDocumentResource\Pages;

use App\Filament\Resources\PurchaseDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseDocument extends EditRecord
{
    protected static string $resource = PurchaseDocumentResource::class;

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
