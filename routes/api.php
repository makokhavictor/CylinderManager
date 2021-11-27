<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function() {
    Route::post('oauth/forgot-password', [AuthController::class, 'update']);
    Route::post('oauth/reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('oauth/user', function () {
        return new UserResource(auth()->user());
    });
    Route::get('oauth/revoke', [AuthController::class, 'destroy']);
    Route::post('oauth/password-change', [AuthController::class, 'passwordChange']);
    Route::get('roles', [RoleController::class, 'index']);

    Route::resources([
        'dealers' => DealerController::class,
        'depots' => DepotController::class,
    ]);
});

Route::middleware('guest:api')->group(function () {
    Route::post('oauth/register', [UserController::class, 'store']);
});
