<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\CrudActionNotification;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Console\View\Components\Task;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
