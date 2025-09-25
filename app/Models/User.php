<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// #[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, MustVerifyEmail, HasName
{
    use HasFactory, Notifiable, HasRoles;

    protected $casts = [
        'image' => 'array',
    ];

    protected $fillable = [
        'code',
        'username',
        'state',
        'first_name',
        'last_name',
        'employee_name',
        'user_type',
        'image',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->username) && !empty($user->employee_name)) {
                $user->username = strtolower(str_replace(' ', '', $user->employee_name));
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $panelId = $panel->getId();

        if (in_array($panelId, ['filament', 'default'])) {
            return true;
        }

        if ($panelId === 'admin') {
            return $this->hasRole('Admin');
        }

        if ($panelId === 'roles') {
            return $this->can('view_any_role');
        }

        if ($panelId === 'warehouses') {
            return $this->can('view_any_warehouse');
        }

        return true;
    }


    public function getFilamentName(): string
    {
        return $this->employee_name
            ?? trim("{$this->first_name} {$this->last_name}")
            ?? 'User';
    }

    public function partner()
    {
        return $this->hasMany(Partner::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
