<?php

namespace App\Policies;

use App\User;
use App\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user super admin
     *
     * @param  \App\User  $user
     * @param   $ability
     * @return mixed
    */

    public function before($user, $ability)
    {
        if ($user->hasRole('owner')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view location');
    }

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $location
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('view location');
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create location');
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $location
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('update location');
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $location
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete location');
    }

}
