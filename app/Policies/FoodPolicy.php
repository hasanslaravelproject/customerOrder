<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the food can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list allfood');
    }

    /**
     * Determine whether the food can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function view(User $user, Food $model)
    {
        return $user->hasPermissionTo('view allfood');
    }

    /**
     * Determine whether the food can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create allfood');
    }

    /**
     * Determine whether the food can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function update(User $user, Food $model)
    {
        return $user->hasPermissionTo('update allfood');
    }

    /**
     * Determine whether the food can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function delete(User $user, Food $model)
    {
        return $user->hasPermissionTo('delete allfood');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete allfood');
    }

    /**
     * Determine whether the food can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function restore(User $user, Food $model)
    {
        return false;
    }

    /**
     * Determine whether the food can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Food  $model
     * @return mixed
     */
    public function forceDelete(User $user, Food $model)
    {
        return false;
    }
}
