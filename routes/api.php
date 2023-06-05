<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, "logout"]);
        Route::get('profile', [AuthController::class, "profile"]);

        Route::controller(ProjectController::class)->group(function () {
            Route::get('projects', 'index');
            Route::get('projects/{id}', 'show');
            Route::post('projects', 'store');
            Route::patch('projects/{project}', 'update');
            Route::delete('projects/{id}', 'destroy');
        });
    });
});
