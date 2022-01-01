<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Permission::count() > 0) {
        return view('welcome', ['db' => 'online']);
    }
    return view('welcome', ['db' => 'offline']);
});

Route::get('895enrg9345fg34g43g3/passport-keys', function () {
    Artisan::call('passport:keys', [
            '--force' => true
        ]
    );
    dd(Artisan::output());
});


Route::get('/895enrg9345fg34g43g3/migrate-refresh', function () {
    Artisan::call('migrate:refresh', [
        '--force' => true,
        '--seed' => true
    ]);
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/migrate', function () {
    Artisan::call('migrate', [
        '--force' => true
    ]);
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/migrate-rollback', function () {
    Artisan::call('migrate:rollback', ['--step' => 1, '--force' => true]);
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/config-clear', function () {
    Artisan::call('config:clear');
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/super-admin-user', function () {
    $user = \App\Models\User::create([
        'email' => 'admin@admin.com',
        'password' => bcrypt('password'),
        'phone' => '+2547000000',
        'first_name' => 'FirstName',
        'last_name' => 'FirstName'
    ]);
    \App\Models\User::find($user->id)->assignRole('Super Admin');
});

Route::get('/895enrg9345fg34g43g3/token', function () {
    $user = \App\Models\User::where('email', 'admin@admin.com')->first();
    echo $user->createToken('Personal Access Token', ['*'])->accessToken;
});

Route::get('/895enrg9345fg34g43g3/redis', function () {
    $app = Redis::connection();
    $app->set('redis-up-message', 'Redis is Up and Running!');
    echo $app->get('redis-up-message');
});

