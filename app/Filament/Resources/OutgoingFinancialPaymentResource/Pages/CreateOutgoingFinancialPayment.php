<?php

namespace App\Filament\Resources\OutgoingFinancialPaymentResource\Pages;

use App\Filament\Resources\OutgoingFinancialPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOutgoingFinancialPayment extends CreateRecord
{
    protected static string $resource = OutgoingFinancialPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
