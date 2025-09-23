<?php

namespace App\Filament\Resources\CashAdvanceReasonResource\Pages;

use App\Filament\Resources\CashAdvanceReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCashAdvanceReason extends CreateRecord
{
    protected static string $resource = CashAdvanceReasonResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
