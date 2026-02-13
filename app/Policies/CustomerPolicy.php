<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('customer_view_any');
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->can('customer_view') && $user->tenant_id === $customer->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->can('customer_create');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->can('customer_update') && $user->tenant_id === $customer->tenant_id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->can('customer_delete') && $user->tenant_id === $customer->tenant_id;
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('customer_delete');
    }

    public function restore(User $user, Customer $customer): bool
    {
        return $user->can('customer_restore') && $user->tenant_id === $customer->tenant_id;
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('customer_restore');
    }

    public function forceDelete(User $user, Customer $customer): bool
    {
        return $user->can('customer_force_delete') && $user->tenant_id === $customer->tenant_id;
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('customer_force_delete');
    }
}
