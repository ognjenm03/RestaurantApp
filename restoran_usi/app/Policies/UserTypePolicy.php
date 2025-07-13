<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the userType can view the model.
     */
    public function view(User $user, UserType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the userType can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the userType can update the model.
     */
    public function update(User $user, UserType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the userType can delete the model.
     */
    public function delete(User $user, UserType $model): bool
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
     * Determine whether the userType can restore the model.
     */
    public function restore(User $user, UserType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the userType can permanently delete the model.
     */
    public function forceDelete(User $user, UserType $model): bool
    {
        return false;
    }
}
