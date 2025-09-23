<?php

namespace App\Filament\Resources\IncomingBankPaymentResource\Pages;

use App\Filament\Resources\IncomingBankPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomingBankPayment extends CreateRecord
{
    protected static string $resource = IncomingBankPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
