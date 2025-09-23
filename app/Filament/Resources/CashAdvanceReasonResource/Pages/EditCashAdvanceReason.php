<?php

namespace App\Filament\Resources\CashAdvanceReasonResource\Pages;

use App\Filament\Resources\CashAdvanceReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCashAdvanceReason extends EditRecord
{
    protected static string $resource = CashAdvanceReasonResource::class;

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
