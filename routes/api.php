<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoachingController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\UserController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/lost-password', [AuthController::class, 'sendResetLinkResponse']);
    Route::post('/user/reset-password', [AuthController::class, 'sendResetResponse']);
    Route::get('/user/verify-email/{id}', [AuthController::class, 'verify'])->name('verification');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/user/logout', [AuthController::class, 'logout']);

    // user controller
    Route::resource('user', UsersController::class);
});



Route::prefix('v1')->namespace('App\Http\Controllers\API')->group(function() {
    // Resources
    Route::resource('coachings','CoachingController');
    Route::resource('categories','CategoryController');
    Route::resource('tags','TagController');
});

// Fallback
Route::fallback(function(){ return response()->json([ 'message' => 'Route not found: Please check spelling d...'], 404); });
