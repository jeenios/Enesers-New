<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use App\Filament\Resources\PartnerCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerCategory extends CreateRecord
{
    protected static string $resource = PartnerCategoryResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
