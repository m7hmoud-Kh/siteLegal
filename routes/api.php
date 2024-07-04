<?php

use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\ClientController;
use App\Http\Controllers\Website\FaqController;
use App\Http\Controllers\Website\MessageController;
use App\Http\Controllers\Website\ProcessController;
use App\Http\Controllers\Website\ServiceController;
use App\Http\Controllers\Website\SettingController;
use App\Http\Controllers\Website\WhyUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(ServiceController::class)->group(function(){
    Route::get('/services','index');
    Route::get('/services/{serviceId}/sections','getAllSectionBasedOnServiceId');
    Route::get('/sections/{sectionId}','getSectionById');

});


Route::controller(MessageController::class)->prefix('/messages')->group(function(){
    Route::post('/','store');
});


Route::controller(ClientController::class)->prefix('/clients')->group(function(){
    Route::get('/','index');
});


Route::controller(FaqController::class)->prefix('/faqs')->group(function(){
    Route::get('/','index');
});


Route::controller(WhyUsController::class)->prefix('/whyus')->group(function(){
    Route::get('/','index');
});


Route::controller(SettingController::class)->prefix('/settings')->group(function(){
    Route::get('/','index');
});

Route::controller(BlogController::class)->prefix('/blogs')->group(function(){
    Route::get('/','index');
    Route::get('/{blogId}','show');

});

Route::controller(ProcessController::class)->prefix('/processes')->group(function(){
    Route::get('/','index');
    Route::get('/{processId}','show');
});


