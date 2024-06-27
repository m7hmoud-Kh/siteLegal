<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('/forget-password','sendEmail');
    Route::post('/reset-password','resetPassword');

});
Route::middleware('auth')->group(function(){
    Route::controller(ProfileController::class)->group(function(){
        Route::post('logout','logout');
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
    });

    Route::controller(ServiceController::class)->prefix('/services')->group(function(){
        Route::get('/','index');
        Route::get('/{serviceId}','show');
        Route::post('/','store');
        Route::post('/{serviceId}','update');
        Route::delete('/{serviceId}','destory');
    });
});
