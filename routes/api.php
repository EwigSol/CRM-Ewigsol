<?php


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
ApiRoute::group(['namespace' => 'App\Http\Controllers\Front'], function () {
    ApiRoute::get('purchased-module', ['as' => 'api.purchasedModule', 'uses' => 'HomeController@installedModule']);
});

ApiRoute::group(['namespace' => 'App\Http\Controllers\Api'], function () {
	ApiRoute::get('lead', ['uses' => 'ApiLeadController@leadList']);
	
	ApiRoute::put('lead/change-status', ['uses' => 'ApiLeadController@changeStatus']);
	
});
/*
ApiRoute::group(
    [
        'middleware' => ['api'],
        'namespace' => 'App\Http\Controllers\Api'],
        function () {
            ApiRoute::resource('lead', 'ApiLeadController');
    }
);
*/