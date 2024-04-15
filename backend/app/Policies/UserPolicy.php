<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyUser(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewUser(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id || $user->is_admin === true;
    }


    /**
     * Determine whether the user can create models.
     */
    public function createUser(User $user, User $targetUser): bool
    {
        return $user->is_admin || $user->id === $targetUser->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateUser(User $user, User $targetUser): bool
    {
        return $user->is_admin || $user->id === $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteUser(User $user, User $targetUser): bool
    {
        return $user->is_admin || $user->id === $targetUser->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreUser(User $user, User $targetUser): bool
    {
        return $user->is_admin || $user->id === $targetUser->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteUser(User $user, User $targetUser): bool
    {
        return $user->is_admin || $user->id === $targetUser->id;
    }
}
