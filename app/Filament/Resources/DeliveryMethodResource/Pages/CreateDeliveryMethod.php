<?php

namespace App\Filament\Resources\DeliveryMethodResource\Pages;

use App\Filament\Resources\DeliveryMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeliveryMethod extends CreateRecord
{
    protected static string $resource = DeliveryMethodResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
