<?php

namespace App\Filament\Resources\SalesDownPaymentResource\Pages;

use App\Filament\Resources\SalesDownPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesDownPayment extends EditRecord
{
    protected static string $resource = SalesDownPaymentResource::class;

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
