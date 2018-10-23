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
use GuzzleHttp\Client;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',function(){
   $query = http_build_query([
        'client_id' => 4,
        'redirect_uri' => "http://localhost/client/public/callback",
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://passport.centrus.local/oauth/authorize?'.$query);
});

Route::get('/callback', function(Request $request) {
   $http = new GuzzleHttp\Client;
   //dd($request);
    $response = $http->post('http://passport.centrus.local/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 4,
            'client_secret' => 'KtkrR0mV0kYQ3GAz3NFkvcO9lqTbA2ip1B8FXDO9',
            'redirect_uri' => "http://localhost/client/public/callback",
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
