<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\AuthController;
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
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/user/logout', [AuthController::class, 'logout']);

    // user controller
    //Route::resource('user', UserController::class);
});

Route::prefix('v1')->namespace('App\Http\Controllers\API')->group(function() {
    // Resources
    Route::resource('coachings','CoachingController');
    Route::resource('coach-country','CoachCountryController');
    Route::resource('coach-type','CoachTypeController');
    Route::resource('coach-category','CoachCategoryController');
    Route::resource('categories','CategoryController');
    Route::resource('tags','TagController');
    Route::resource('requests','RequestController');
});

// Fallback
Route::fallback(function(){ return response()->json([ 'message' => 'Route not found: Please check spelling d...'], 404); });
