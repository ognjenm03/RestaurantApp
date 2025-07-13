<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuCategorie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuCategoriePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the menuCategorie can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the menuCategorie can view the model.
     */
    public function view(User $user, MenuCategorie $model): bool
    {
        return true;
    }

    /**
     * Determine whether the menuCategorie can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the menuCategorie can update the model.
     */
    public function update(User $user, MenuCategorie $model): bool
    {
        return true;
    }

    /**
     * Determine whether the menuCategorie can delete the model.
     */
    public function delete(User $user, MenuCategorie $model): bool
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
     * Determine whether the menuCategorie can restore the model.
     */
    public function restore(User $user, MenuCategorie $model): bool
    {
        return false;
    }

    /**
     * Determine whether the menuCategorie can permanently delete the model.
     */
    public function forceDelete(User $user, MenuCategorie $model): bool
    {
        return false;
    }
}
