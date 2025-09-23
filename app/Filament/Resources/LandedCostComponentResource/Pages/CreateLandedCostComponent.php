<?php

namespace App\Filament\Resources\LandedCostComponentResource\Pages;

use App\Filament\Resources\LandedCostComponentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLandedCostComponent extends CreateRecord
{
    protected static string $resource = LandedCostComponentResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
