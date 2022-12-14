<?php

namespace App\Policies;

use App\Models\Exhibition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExhibitionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['admin', 'artist']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exhibition  $exhibition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Exhibition $exhibition)
    {
        return $user->hasRole('admin') || ($user->hasRole('artist') && (int) $exhibition->user_id === (int) $user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('artist');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exhibition  $exhibition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Exhibition $exhibition)
    {
        return $user->hasRole('admin') || ($user->hasRole('artist') && (int) $exhibition->user_id === (int) $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exhibition  $exhibition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Exhibition $exhibition)
    {
        return $user->hasRole('admin') || ($user->hasRole('artist') && (int) $exhibition->user_id === (int) $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exhibition  $exhibition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Exhibition $exhibition)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exhibition  $exhibition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Exhibition $exhibition)
    {
        return $user->hasRole('admin');
    }
}
