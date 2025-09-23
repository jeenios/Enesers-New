<?php

namespace App\Filament\Resources\FinancialAccountResource\Pages;

use App\Filament\Resources\FinancialAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialAccount extends CreateRecord
{
    protected static string $resource = FinancialAccountResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
