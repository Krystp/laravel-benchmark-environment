<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostgresController;
use App\Http\Controllers\MongodbController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('postgres/{limit?}', [PostgresController::class, 'getPostgres']);
Route::get('postgres/getbyid/{id}', [PostgresController::class, 'getPostgresById']);
Route::post('postgres', [PostgresController::class, 'createPostgres']);
Route::put('postgres/{id}', [PostgresController::class, 'updatePostgres']);
Route::delete('postgres/{id}', [PostgresController::class, 'deletePostgres']);

Route::get('/mongodb/{limit?}', [MongodbController::class, 'getMongodb']);
Route::get('/mongodb/getbyid/{id}', [MongodbController::class, 'getMongodbById']);
Route::post('/mongodb', [MongodbController::class, 'createMongodb']);
Route::put('/mongodb/{id}', [MongodbController::class, 'updateMongodb']);
Route::delete('/mongodb/{id}', [MongodbController::class, 'deleteMongodb']);
