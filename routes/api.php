<?php

use App\Http\Controllers\Api\User\UserPrefrenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/users/{user}')->name('users.*')->group(function () {
    Route::prefix('user-prefrences')->name('user-prefrences.*')->group(function () {
        Route::post('/', [UserPrefrenceController::class, 'store'])->name('store');
        Route::put('/{userPrefrence}', [UserPrefrenceController::class, 'update'])->name('update');
    });
});
