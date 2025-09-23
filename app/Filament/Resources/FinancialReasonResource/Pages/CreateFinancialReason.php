<?php

namespace App\Filament\Resources\FinancialReasonResource\Pages;

use App\Filament\Resources\FinancialReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialReason extends CreateRecord
{
    protected static string $resource = FinancialReasonResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
