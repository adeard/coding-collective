<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    return view('welcome');
});

// TEMPORARY FOR GETTING AUTHORIZATION
Route::get('/authorize', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));

    $query = http_build_query([
        'client_id' => $request->client_id,
        'redirect_uri' => $request->redirect_uri,
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
    ]);

    return env('APP_URL').'/oauth/authorize?'.$query;
});
//-----------------------------------------------------------------

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/clients', function (Request $request){
    return view('clients', [
        'clients' => $request->user()->clients
    ]);
})->middleware(['auth'])->name('dashboard.clients');

require __DIR__.'/auth.php';
