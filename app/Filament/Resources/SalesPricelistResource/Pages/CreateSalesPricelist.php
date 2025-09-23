<?php

namespace App\Filament\Resources\SalesPricelistResource\Pages;

use App\Filament\Resources\SalesPricelistResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesPricelist extends CreateRecord
{
    protected static string $resource = SalesPricelistResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
