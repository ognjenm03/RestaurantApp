<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Table;
use Illuminate\Auth\Access\HandlesAuthorization;

class TablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the table can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the table can view the model.
     */
    public function view(User $user, Table $model): bool
    {
        return true;
    }

    /**
     * Determine whether the table can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the table can update the model.
     */
    public function update(User $user, Table $model): bool
    {
        return true;
    }

    /**
     * Determine whether the table can delete the model.
     */
    public function delete(User $user, Table $model): bool
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
     * Determine whether the table can restore the model.
     */
    public function restore(User $user, Table $model): bool
    {
        return false;
    }

    /**
     * Determine whether the table can permanently delete the model.
     */
    public function forceDelete(User $user, Table $model): bool
    {
        return false;
    }
}
