<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\Api\AuthController;

Route::post('register', [AuthController:: class, 'register']);
Route::post('login', [AuthController:: class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController:: class, 'logout']);
});
