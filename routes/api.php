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

    /*
    | By Default, Create , Update and delete are reserved for only Admins.
    | Other users can only get the info.This can be managed by AllowAccess Middleware
    | Feel free to change the access,but prefer not to.
    |
    */

    //Products
    Route::prefix('products')->middleware(APILog::class)->group(function () {

        /*---------------------Reserved for admins----------------------*/

        Route::post('create', 'ProductsController@create');
        Route::patch('update/{id}', 'ProductsController@update');
        Route::delete('{id}', 'ProductsController@delete');

        /*---------------------Reserved for admins----------------------*/

        Route::get('all', 'ProductsController@index');
        Route::get('{id}', 'ProductsController@show');
    });

    //Categories
    Route::prefix('categories')->middleware(APILog::class)->group(function () {

        /*---------------------Reserved for admins----------------------*/

        Route::post('create', 'CategoriesController@create');
        Route::patch('update/{id}', 'CategoriesController@update');
        Route::delete('{id}', 'CategoriesController@delete');

        /*---------------------Reserved for admins----------------------*/

        Route::get('all', 'CategoriesController@index');
        Route::get('{id}', 'CategoriesController@show');
    });

    //Product-Variants
    Route::prefix('variants')->middleware(APILog::class)->group(function () {

        /*---------------------Reserved for admins----------------------*/

        Route::post('create', 'VariantsController@create');
        Route::patch('update/{id}', 'VariantsController@update');
        Route::delete('{id}', 'VariantsController@delete');

        /*---------------------Reserved for admins----------------------*/

        Route::get('all', 'VariantsController@index');
        Route::get('{id}', 'VariantsController@show');
    });
});
