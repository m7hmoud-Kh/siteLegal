<?php

use App\Http\Controllers\Website\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(ServiceController::class)->prefix('/services')->group(function(){
    Route::get('/','index');
});
