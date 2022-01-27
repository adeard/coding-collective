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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'namespace' => 'App\Http\Controllers',
], function (){
    Route::post('register', 'UserController@register');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', 'UserController@logout');

        Route::resource('roles', 'RoleController');

        Route::group(['prefix' => 'user'], function() {
            Route::get('', 'UserController@profile');
            Route::put('{id}', 'UserController@update');
        });

        Route::group(['prefix' => 'candidates'], function() {
            Route::get('', 'CandidateController@index');
            Route::get('{id}', 'CandidateController@show');

            Route::group(['middleware' => 'auth.hrd'], function() {

                Route::post('resume', 'CandidateResumeController@store');

                Route::post('', 'CandidateController@store');
                Route::put('{id}', 'CandidateController@update');
            });
        });
    });
});
