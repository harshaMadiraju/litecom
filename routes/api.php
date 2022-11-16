<?php

use App\Http\Middleware\AllowAccess;
use App\Http\Middleware\APILog;
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

Route::post('login', 'ApiController@authenticate');

//Authenticated Routes
Route::middleware(['jwt.verify', AllowAccess::class])->group(function () {

    //Products Module for example
    Route::prefix('products')->middleware(APILog::class)->group(function () {
        Route::get('all', 'ProductsController@index');
        Route::post('create', 'ProductsController@create');
        Route::patch('update/{id}', 'ProductsController@update');
        Route::get('{id}', 'ProductsController@show');
        Route::delete('{id}', 'ProductsController@delete');
    });
});
