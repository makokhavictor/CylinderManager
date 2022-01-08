<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Resources\CreatedUserResource;
use App\Http\Resources\UpdatedUserResource;
use App\Http\Resources\DeletedUserResource;
use App\Http\Resources\UserCollection;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Role;
use App\Models\Transporter;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = new User();
        return UserCollection::make($users->paginate());
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create([
            'username' => $request->get('username'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => bcrypt(md5(rand(1, 1000))),
        ]);

        if ($request->get('stationSpecificRoles')) {
            $allocations = $request->get('stationSpecificRoles');

            foreach ($allocations as $key => $allocation) {
                if (key_exists('transporterId', $allocation)) {
                    $user->permissibleRoles()->save(Role::find($allocation['roleId']),
                        ['permissible_id' => $allocation['transporterId'], 'permissible_type' => Transporter::class]
                    );
                }
                if (key_exists('dealerId', $allocation)) {
                    $user->permissibleRoles()->save(Role::find($allocation['roleId']),
                        ['permissible_id' =>$allocation['dealerId'], 'permissible_type' => Dealer::class]
                    );
                }
                if (key_exists('depotId', $allocation)) {
                    $user->permissibleRoles()->save(Role::find($allocation['roleId']),
                        ['permissible_id' => $allocation['depotId'], 'permissible_type' => Depot::class]
                    );
                }

            }


        }

        return response()->json(new CreatedUserResource($user))->setStatusCode(201);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'username' => $request->get('username'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => bcrypt(md5(rand(1, 1000))),
        ]);

        return response()->json(new UpdatedUserResource($user));
    }

    public function destroy(UserDeleteRequest $request, User $user)
    {
        $user->delete();

        return response()->json(new DeletedUserResource($user));
    }
}
