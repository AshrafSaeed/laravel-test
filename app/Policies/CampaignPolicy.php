<?php

namespace App\Policies;

use App\User;
use App\Campaign;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class CampaignPolicy
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
     * Determine whether the user can view any campaigns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view campaign');
    }

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('view campaign');
    }

    /**
     * Determine whether the user can create campaigns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create campaign');
    }

    /**
     * Determine whether the user can update the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('update campaign');
    }

    /**
     * Determine whether the user can delete the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete campaign');
    }

    /**
     * Determine whether the user can publish the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function publish(User $user)
    {
        return $user->hasPermissionTo('publish campaign');
    }

     /**
     * Determine whether the user can unpublish the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function unpublish(User $user)
    {
        return $user->hasPermissionTo('unpublish campaign');
    }

    
}
