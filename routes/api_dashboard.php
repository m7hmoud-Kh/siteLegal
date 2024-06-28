<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\ProcessController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SectionController;
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
        Route::get('/service-selection','showGroupInSelection');
        Route::get('/{serviceId}','show');
        Route::post('/','store');
        Route::post('/{serviceId}','update');
        Route::delete('/{serviceId}','destory');
    });

    Route::controller(SectionController::class)->prefix('/sections')->group(function(){
        Route::get('/','index');
        Route::get('/{sectionId}','show');
        Route::post('/','store');
        Route::post('/{sectionId}','update');
        Route::delete('/{sectionId}','destory');
    });

    Route::controller(ProcessController::class)->prefix('/processes')->group(function(){
        Route::get('/','index');
        Route::get('/{processId}','show');
        Route::post('/','store');
        Route::post('/{processId}','update');
        Route::delete('/{processId}','destory');
    });

    Route::controller(BlogController::class)->prefix('/blogs')->group(function(){
        Route::get('/','index');
        Route::get('/{blogId}','show');
        Route::post('/','store');
        Route::post('/{blogId}','update');
        Route::delete('/{blogId}','destory');
    });
});
