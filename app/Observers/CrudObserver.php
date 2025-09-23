<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CrudObserver
{
    protected function getModelName($model): string
    {
        // Ambil nama model secara otomatis
        return Str::headline(class_basename($model));
    }

    protected function getUserName(): string
    {
        return Auth::user()?->employee_name ?? 'System';
    }

    public function created($model): void
    {
        $this->notifyAllUsers(
            "New {$this->getModelName($model)} Created",
            "A new {$this->getModelName($model)} has been created by {$this->getUserName()}."
        );
    }

    public function updated($model): void
    {
        $this->notifyAllUsers(
            "{$this->getModelName($model)} Updated",
            "A {$this->getModelName($model)} has been updated by {$this->getUserName()}."
        );
    }

    public function deleted($model): void
    {
        $this->notifyAllUsers(
            "{$this->getModelName($model)} Deleted",
            "A {$this->getModelName($model)} has been deleted by {$this->getUserName()}."
        );
    }

    protected function notifyAllUsers(string $title, string $body): void
    {
        foreach (User::all() as $user) {
            Notification::make()
                ->title($title)
                ->body($body)
                ->sendToDatabase($user);
        }
    }
}
