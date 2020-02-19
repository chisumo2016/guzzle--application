<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('redirect ' ,function (){

    $query = http_build_query([
        'client_id' => '8',
        'redirect_uri' => 'http://127.0.0.1:8000/callback',   //CLIENT
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://localhost::8000/oauth/authorize?'.$query);  //MY WEBSITE UR
})->name('get.token');



Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost::8000/oauth/token', [   // COSUMER
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '8',
            'client_secret' => 'client-secret',
            'redirect_uri' => 'http://client.dev/callback',   // MY WEBSITE
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
