<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix' => 'category', 'namespace' => 'API', 'middleware' => 'auth:sanctum'], function () {
    Route::get('list', [ApiController::class, 'categoryList']);
    Route::post('create', [ApiController::class, 'createCategory']);
    Route::get('details/{id}', [ApiController::class, 'categoryDetail']);
    Route::get('delete/{id}', [ApiController::class, 'categoryDelete']);
    Route::post('update', [ApiController::class, 'categoryUpdate']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
});
