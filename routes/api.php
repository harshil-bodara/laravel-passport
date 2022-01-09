<?php

use App\Http\Controllers\API\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/lost-password', [AuthController::class, 'sendResetLinkResponse']);
    Route::post('/user/reset-password', [AuthController::class, 'sendResetResponse']);
    Route::get('/user/verify-email/{id}', [AuthController::class, 'verify']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::get('/user/profile/{id}', [AuthController::class, 'get_profile']);
    Route::post('/user/update_profile', [AuthController::class, 'update_profile']);
    Route::delete('/user/delete_profile/{id}', [AuthController::class, 'delete_profile']);
});
