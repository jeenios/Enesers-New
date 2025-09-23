<?php

namespace App\Filament\Resources\LandedCostComponentResource\Pages;

use App\Filament\Resources\LandedCostComponentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLandedCostComponent extends EditRecord
{
    protected static string $resource = LandedCostComponentResource::class;

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
