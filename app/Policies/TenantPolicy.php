<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tenant');
    }

    public function view(User $user, Tenant $tenant): bool
    {
        return $user->can('view_tenant');
    }

    public function create(User $user): bool
    {
        return $user->can('create_tenant');
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $user->can('update_tenant');
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $user->can('delete_tenant');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_tenant');
    }

    public function forceDelete(User $user, Tenant $tenant): bool
    {
        return $user->can('force_delete_tenant');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_tenant');
    }

    public function restore(User $user, Tenant $tenant): bool
    {
        return $user->can('restore_tenant');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_tenant');
    }

    public function replicate(User $user, Tenant $tenant): bool
    {
        return $user->can('replicate_tenant');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_tenant');
    }
}
