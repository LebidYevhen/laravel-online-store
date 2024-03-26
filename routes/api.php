<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Resources\TestResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test/{value}', function (string $value) {
    return new TestResource(['value' => $value]);
});

Route::fallback(function () {
    abort(404, 'API resource not found');
});

Route::prefix('v1')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegisterController::class, 'register']);
        Route::middleware('auth:sanctum')->get('/token', [TokenController::class, 'get']);
        Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
            return $request->user();
        });
        Route::middleware('auth:sanctum')->post('/logout', [LogoutController::class, 'logout']);
    });
});



