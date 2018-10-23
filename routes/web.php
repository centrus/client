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


Route::get('/redirect',function(){
   $query = http_build_query([
        'client_id' => 5,
        'redirect_uri' => "http://localhost/client/public/callback",
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://passport.dev/oauth/authorize?'.$query);
});

Route::get('/callback', function(Request $request) {
   $http = new GuzzleHttp\Client;
   //dd($request);
    $response = $http->post('http://passport.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 5,
            'client_secret' => '1crEkNIDwF5g0ntcP5QFIs8JbK37pgtHLXSgzE3y',
            'redirect_uri' => "http://localhost/client/public/callback",
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
