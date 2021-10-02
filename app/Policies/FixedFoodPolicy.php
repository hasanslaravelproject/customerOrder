<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FixedFood;
use Illuminate\Auth\Access\HandlesAuthorization;

class FixedFoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fixedFood can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fixedfoods');
    }

    /**
     * Determine whether the fixedFood can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function view(User $user, FixedFood $model)
    {
        return $user->hasPermissionTo('view fixedfoods');
    }

    /**
     * Determine whether the fixedFood can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fixedfoods');
    }

    /**
     * Determine whether the fixedFood can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function update(User $user, FixedFood $model)
    {
        return $user->hasPermissionTo('update fixedfoods');
    }

    /**
     * Determine whether the fixedFood can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function delete(User $user, FixedFood $model)
    {
        return $user->hasPermissionTo('delete fixedfoods');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fixedfoods');
    }

    /**
     * Determine whether the fixedFood can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function restore(User $user, FixedFood $model)
    {
        return false;
    }

    /**
     * Determine whether the fixedFood can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FixedFood  $model
     * @return mixed
     */
    public function forceDelete(User $user, FixedFood $model)
    {
        return false;
    }
}
