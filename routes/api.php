<?php

use App\Http\Controllers\{AuthController, FriendshipController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::prefix('users')->group(function () {
        Route::get('/friends', [UserController::class, 'friends']);
        Route::get('/search', [UserController::class, 'search']);
    });

    Route::prefix('friends')->group(function () {
        Route::get('/requests', [FriendshipController::class, 'pendingRequests']);
        Route::post('/requests/{friend}', [FriendshipController::class, 'sendRequest']);
        Route::post('/requests/accept/{friendRequest}', [FriendshipController::class, 'acceptRequest']);
        Route::post('/requests/reject/{friendRequest}', [FriendshipController::class, 'rejectRequest']);
    });

});
