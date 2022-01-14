<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CanisterController;
use App\Http\Controllers\CanisterDispatchController;
use App\Http\Controllers\CanisterLogController;
use App\Http\Controllers\CanisterStatisticsController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StationRoleController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TransporterController;
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

Route::middleware(['auth:api', 'activity-time-logger'])->group(function () {
    Route::get('{station}/{stationId}/roles', [StationRoleController::class, 'index']);
    Route::get('oauth/user', function () {
        return UserResource::make(auth()->user());
    });
    Route::get('oauth/revoke', [AuthController::class, 'destroy']);
    Route::post('oauth/password-change', [AuthController::class, 'passwordChange']);
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('depots/{depot}/statistics',[CanisterStatisticsController::class, 'depots']);
    Route::get('dealers/{dealer}/statistics',[CanisterStatisticsController::class, 'dealers']);
    Route::get('transporters/{transporter}/statistics',[CanisterStatisticsController::class, 'transporters']);
    Route::get('statistics/dashboard-summary', [StatisticsController::class, 'dashboardSummary']);
    Route::resources([
        'canisters/batch-dispatches' => CanisterDispatchController::class,
//        'depots/{depot}/canisters' => CanisterController::class,
        'canisters' => CanisterController::class,
        'dealers' => DealerController::class,
        'depots' => DepotController::class,
        'transporters' => TransporterController::class,
        'brands' => BrandController::class,
        'users' => UserController::class
    ]);
    Route::post('canister-logs', [CanisterLogController::class, 'store']);

});
