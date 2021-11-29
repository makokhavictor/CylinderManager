<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterDepotUserController extends Controller
{
    public function store()
    {
        $user = User::find(auth()->id());
        $user ->depotUser()->create([]);
        $user->assignRole('Depot Admin');

        return response()->json([
            'data' => UserResource::make(User::find(auth()->id())),
            'headers' => [
                'message' => 'Successfully registered user as a depot user'
            ]
        ])->setStatusCode(201);
    }
}
