<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\CreatedUserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $users = new User();
        return UserCollection::make($users->paginate());
    }

    public function store(UserStoreRequest $request) {
        $user = User::create([
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json(new CreatedUserResource($user))->setStatusCode(201);
    }
}
