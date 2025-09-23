<?php

namespace App\Filament\Resources\SalesDownPaymentResource\Pages;

use App\Filament\Resources\SalesDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesDownPayment extends CreateRecord
{
    protected static string $resource = SalesDownPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
