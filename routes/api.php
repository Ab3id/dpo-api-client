<?php

use App\Http\Controllers\TokenContoller;
use Illuminate\Http\Request;

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

Route::prefix('/v1/client')->group(function(){
    Route::post('generate_token',[TokenContoller::class, 'create']);
    Route::get('get_payment_options',[TokenContoller::class, 'getMNOpaymentOptions']);
    Route::post('charge_token',[TokenContoller::class, 'chargeTokenwithMNO']);

    // getMNOpaymentOptions
});