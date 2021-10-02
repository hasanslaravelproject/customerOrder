<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the menuCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list menucategories');
    }

    /**
     * Determine whether the menuCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function view(User $user, MenuCategory $model)
    {
        return $user->hasPermissionTo('view menucategories');
    }

    /**
     * Determine whether the menuCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create menucategories');
    }

    /**
     * Determine whether the menuCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function update(User $user, MenuCategory $model)
    {
        return $user->hasPermissionTo('update menucategories');
    }

    /**
     * Determine whether the menuCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function delete(User $user, MenuCategory $model)
    {
        return $user->hasPermissionTo('delete menucategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete menucategories');
    }

    /**
     * Determine whether the menuCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function restore(User $user, MenuCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the menuCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MenuCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, MenuCategory $model)
    {
        return false;
    }
}
