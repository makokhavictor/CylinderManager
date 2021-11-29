<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransporterUserDeleteRequest;
use App\Http\Requests\TransporterUserStoreRequest;
use App\Http\Requests\TransporterUserUpdateRequest;
use App\Http\Resources\TransporterCollection;
use App\Http\Resources\TransporterUserCollection;
use App\Http\Resources\TransporterUserResource;
use App\Http\Resources\UserResource;
use App\Models\Transporter;
use App\Models\TransporterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransporterUserController extends Controller
{
    public function index(Transporter $transporter)
    {
        return response()->json(TransporterUserCollection::make($transporter->transporterUsers()->paginate()));
    }

    public function show(Transporter $transporter, User $user)
    {
        return response()->json([
            'data' => UserResource::make($user)
        ]);
    }

    public function store(TransporterUserStoreRequest $request, Transporter $transporter)
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
        $transporter->transporterUsers()->create([
            'user_id' => $user->id
        ]);
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully created transporter user'
            ]
        ])->setStatusCode(201);
    }

    public function update(TransporterUserUpdateRequest $request, Transporter $transporter, User $user)
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
                'message' => 'Successfully updated transporter user'
            ]
        ]);
    }

    public function destroy(TransporterUserDeleteRequest $request, Transporter $transporter, User $user) {

        $user->transporterUser()->delete();
        return response()->json([
            'data' => UserResource::make($user),
            'headers' => [
                'message' => 'Successfully deleted transporter user'
            ]
        ]);
    }

}
