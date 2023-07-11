<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // Rute-rute yang membutuhkan auth dan throttle
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{uuid}', [ProductController::class, 'show']);

    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/transaction/{uuid}', [TransactionController::class, 'show']);
    //admin
    Route::middleware(['admin'])->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::post('/products/{uuid}', [ProductController::class, 'update']);
        Route::delete('/products/{uuid}', [ProductController::class, 'destroy']);
    });
    //customer
    Route::middleware(['customer'])->group(function () {
        Route::post('/transaction', [TransactionController::class, 'store']);
    });
});
