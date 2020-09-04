<?php

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

Route::middleware(['api', 'auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    return 'test ok...';
});

Route::middleware('auth:api')->get('auth-test', function () {
    return 'auth-test ok...';
});

Route::get('user/find', 'Tests\\Controllers\\UserController@find');
Route::post('user/list', 'Tests\\Controllers\\UserController@list');
Route::post('user/create', 'Tests\\Controllers\\UserController@create');
Route::post('user/update', 'Tests\\Controllers\\UserController@update');
Route::delete('user/delete', 'Tests\\Controllers\\UserController@delete');
