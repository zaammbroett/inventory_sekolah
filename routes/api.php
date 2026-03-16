<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Route API untuk aplikasi inventory
*/

// ========================
// PUBLIC ROUTES
// ========================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ========================
// PRIVATE ROUTES (SANCTUM)
// ========================
Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('transactions', TransactionController::class);

});


// ========================
// GET USER LOGIN
// ========================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});