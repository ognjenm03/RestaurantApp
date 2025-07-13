<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the orderItem can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the orderItem can view the model.
     */
    public function view(User $user, OrderItem $model): bool
    {
        return true;
    }

    /**
     * Determine whether the orderItem can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the orderItem can update the model.
     */
    public function update(User $user, OrderItem $model): bool
    {
        return true;
    }

    /**
     * Determine whether the orderItem can delete the model.
     */
    public function delete(User $user, OrderItem $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the orderItem can restore the model.
     */
    public function restore(User $user, OrderItem $model): bool
    {
        return false;
    }

    /**
     * Determine whether the orderItem can permanently delete the model.
     */
    public function forceDelete(User $user, OrderItem $model): bool
    {
        return false;
    }
}
