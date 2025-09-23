<?php

namespace App\Filament\Resources\IncomingFinancialPaymentResource\Pages;

use App\Filament\Resources\IncomingFinancialPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomingFinancialPayment extends CreateRecord
{
    protected static string $resource = IncomingFinancialPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
