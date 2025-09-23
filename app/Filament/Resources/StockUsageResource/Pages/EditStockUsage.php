<?php

namespace App\Filament\Resources\StockUsageResource\Pages;

use App\Filament\Resources\StockUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockUsage extends EditRecord
{
    protected static string $resource = StockUsageResource::class;

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
