<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterTransporterUserController extends Controller
{
    public function store()
    {
        $user = User::find(auth()->id());
        $user ->transporterUser()->create([]);
        $user->assignRole('Transporter Admin');

        return response()->json([
            'data' => UserResource::make(User::find(auth()->id())),
            'headers' => [
                'message' => 'Successfully registered user as a depot user'
            ]
        ])->setStatusCode(201);
    }
}
