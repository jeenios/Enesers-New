<?php

namespace App\Filament\Resources\FinancialReasonResource\Pages;

use App\Filament\Resources\FinancialReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialReason extends EditRecord
{
    protected static string $resource = FinancialReasonResource::class;

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
