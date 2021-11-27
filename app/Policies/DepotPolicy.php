<?php

namespace App\Policies;

use App\Models\Depot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DepotPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Depot $depot)
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
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Depot $depot)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Depot $depot)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
        echo "YEEEEEEEEEEEEEEEEEEEEEEEE";
        return $user->can('delete depot');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Depot $depot)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Depot $depot)
    {
        //
    }
}
