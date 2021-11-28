<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepotUserDeleteRequest;
use App\Http\Requests\DepotUserStoreRequest;
use App\Http\Requests\DepotUserUpdateRequest;
use App\Http\Resources\DepotCollection;
use App\Http\Resources\DepotUserCollection;
use App\Http\Resources\DepotUserResource;
use App\Http\Resources\UserResource;
use App\Models\Depot;
use App\Models\DepotUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepotUserController extends Controller
{
    public function index(Depot $depot)
    {
        return response()->json(DepotUserCollection::make($depot->depotUsers()->paginate()));
    }

    public function show(Depot $depot, User $user)
    {
        return response()->json([
            'data' => UserResource::make($user)
        ]);
    }

    public function store(DepotUserStoreRequest $request, Depot $depot)
    {
        $password = Str::random(10);
        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'password' => bcrypt($password)
        ]);
        $depot->depotUsers()->create([
            'user_id' => $user->id
        ]);
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully created depot user'
            ]
        ])->setStatusCode(201);
    }

    public function update(DepotUserUpdateRequest $request, Depot $depot, User $user)
    {
        $fields = [
            'username' => 'username',
            'firstName' => 'first_name',
            'lastName' => 'last_name',
            'email' => 'email',
            'phone' => 'phone'
        ];
        $params = [];
        foreach ($fields as $key => $item) {
            if ($request->get($key)) {
                $params[$item] = $request->get($key);
            }
        }

        $user->update($params);

        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully updated depot user'
            ]
        ]);
    }

    public function destroy(DepotUserDeleteRequest $request, Depot $depot, User $user) {

        $user->depotUser()->delete();
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully deleted depot user'
            ]
        ]);
    }

}
