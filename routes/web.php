<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::any('/{any}', function (Request $request) {
    $method = new \ReflectionProperty($request, 'method');
    $method->setAccessible(true);
    $pathInfo = new \ReflectionProperty($request, 'pathInfo');
    $pathInfo->setAccessible(true);
    $requestUri = new \ReflectionProperty($request, 'requestUri');
    $requestUri->setAccessible(true);
    $baseUrl = new \ReflectionProperty($request, 'baseUrl');
    $baseUrl->setAccessible(true);
    $allInfo = [
        'method'                  => $method->getValue($request),
        'pathInfo'                => $pathInfo->getValue($request),
        'requestUri'              => $requestUri->getValue($request),
        'baseUrl'                 => $baseUrl->getValue($request),
        'data'                    => $request->all(),
        'apache_response_headers' => apache_response_headers(),
        'headers_list'            => headers_list(),
        'apache_request_headers'  => apache_request_headers(),
        'getallheaders'           => getallheaders()
    ];
    Storage::disk('local')->put(Str::random(40) . '.json', json_encode($allInfo, JSON_PRETTY_PRINT));
    return $allInfo;
})->where('any', '.*');
