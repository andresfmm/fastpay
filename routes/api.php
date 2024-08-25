<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

use App\Http\Middleware\JwtMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




/*
    |--------------------------------------------------------------------------
    | API Routes detail payments
    |--------------------------------------------------------------------------
    |
    | Here is where you can handle request relate
    | payments and detail payment
    |
*/
Route::middleware([JwtMiddleware::class])->group(function () {
    
    Route::get('/v1/payments', [PaymentController::class, 'index']);

    Route::post('/v1/payments', [PaymentController::class, 'show']);

    Route::post('/v1/payment', [PaymentController::class, 'store']);

    Route::post('/v1/proccess-payment', [PaymentController::class, 'proccess']);

});


/*
    |--------------------------------------------------------------------------
    | API Routes handle user
    |--------------------------------------------------------------------------
    |
    | Here is where you can handle request relate
    | users 
    |
*/

Route::post('/v1/login', [UserController::class, 'login']); //->middleware('throttle:10,1');

Route::middleware([JwtMiddleware::class])->group(function () { 

    Route::post('/v1/logout', [UserController::class, 'logout']);

});

