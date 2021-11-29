<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterDealerUserController extends Controller
{
    public function store()
    {
        $user = User::find(auth()->id());
        $user ->dealerUser()->create([]);
        $user->assignRole('Dealer Admin');

        return response()->json([
            'data' => UserResource::make(User::find(auth()->id())),
            'headers' => [
                'message' => 'Successfully registered user as a dealer user'
            ]
        ])->setStatusCode(201);
    }
}
