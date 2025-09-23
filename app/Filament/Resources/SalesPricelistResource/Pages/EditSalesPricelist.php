<?php

namespace App\Filament\Resources\SalesPricelistResource\Pages;

use App\Filament\Resources\SalesPricelistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesPricelist extends EditRecord
{
    protected static string $resource = SalesPricelistResource::class;

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
