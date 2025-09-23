<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResourceModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    /**
     * Admin bisa akses semua resource
     */
    public function before(User $user, $ability): ?bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
        return null;
    }

    protected function canAccess(User $user, $model): bool
    {
        $class = is_string($model) ? $model : get_class($model);

        if ($user->hasRole('Warehouse') && $class === \App\Models\Warehouse::class) {
            return true;
        }

        if ($user->hasRole('Finance') && $class === \App\Models\Currency::class) {
            return true;
        }

        return false;
    }

    public function viewAny(User $user, string $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function view(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function create(User $user, string $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function update(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }

    public function delete(User $user, $model): bool
    {
        return $this->canAccess($user, $model);
    }
}
