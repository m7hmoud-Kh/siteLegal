<?php

use App\Http\Controllers\Website\ClientController;
use App\Http\Controllers\Website\FaqController;
use App\Http\Controllers\Website\MessageController;
use App\Http\Controllers\Website\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(ServiceController::class)->prefix('/services')->group(function(){
    Route::get('/','index');
    Route::get('/{serviceId}/sections','getAllSectionBasedOnServiceId');

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
