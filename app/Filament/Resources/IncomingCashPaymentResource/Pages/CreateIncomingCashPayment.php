<?php

namespace App\Filament\Resources\IncomingCashPaymentResource\Pages;

use App\Filament\Resources\IncomingCashPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomingCashPayment extends CreateRecord
{
    protected static string $resource = IncomingCashPaymentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
