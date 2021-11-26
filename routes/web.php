<?php

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
    Artisan::call('passport:keys');
    dd(Artisan::output());
});


Route::get('/895enrg9345fg34g43g3/migrate-refresh', function () {
    Artisan::call('migrate:refresh');
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/migrate', function () {
    Artisan::call('migrate');
    dd(Artisan::output());
});

Route::get('/895enrg9345fg34g43g3/migrate-rollback', function () {
    Artisan::call('migrate:rollback', ['--step' => 1]);
    dd(Artisan::output());
});
