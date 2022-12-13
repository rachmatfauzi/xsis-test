<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;

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

Route::group(['prefix' => 'Movies'], function () {
    Route::get('/', [MoviesController::class, 'index']);
    Route::get('/{id}', [MoviesController::class, 'showById']);
    Route::delete('/{id}', [MoviesController::class, 'deleteData']);
    Route::post('/', [MoviesController::class, 'postData']);
//    Route::post('/batch', [MoviesController::class, 'batchPostData']);
//    Route::post('/batch-delete', [MoviesController::class, 'batchDeleteData']);
    Route::patch('/', [MoviesController::class, 'updateData']);
});
