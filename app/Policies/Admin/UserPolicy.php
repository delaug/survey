<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $subject
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability) {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, $subject)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, $subject)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, $subject)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, $subject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, $subject)
    {
        //
    }
}
