<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealerUserDeleteRequest;
use App\Http\Requests\DealerUserStoreRequest;
use App\Http\Requests\DealerUserUpdateRequest;
use App\Http\Resources\DealerUserCollection;
use App\Http\Resources\UserResource;
use App\Models\DealerUser;
use App\Http\Requests\StoreDealerUserRequest;
use App\Http\Requests\UpdateDealerUserRequest;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Support\Str;

class DealerUserController extends Controller
{
    public function index(Dealer $dealer)
    {
        return response()->json(DealerUserCollection::make($dealer->dealerUsers()->paginate()));
    }

    public function show(Dealer $dealer, User $user)
    {
        return response()->json([
            'data' => UserResource::make($user)
        ]);
    }

    public function store(DealerUserStoreRequest $request, Dealer $dealer)
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
        $dealer->dealerUsers()->create([
            'user_id' => $user->id
        ]);
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully created dealer user'
            ]
        ])->setStatusCode(201);
    }

    public function update(DealerUserUpdateRequest $request, Dealer $dealer, User $user)
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
                'message' => 'Successfully updated dealer user'
            ]
        ]);
    }

    public function destroy(DealerUserDeleteRequest $request, Dealer $dealer, User $user) {

        $user->dealerUser()->delete();
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully deleted dealer user'
            ]
        ]);
    }

}
