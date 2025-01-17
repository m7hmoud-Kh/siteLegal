<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\FaqController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\MessageController;
use App\Http\Controllers\Dashboard\ProcessController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\WhyUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('/forget-password','sendEmail');
    Route::post('/reset-password','resetPassword');

});


Route::middleware('auth')->group(function(){

    Route::middleware(['role:super_admin'])
    ->controller(ManagerController::class)
    ->prefix('managers')
    ->group(function(){
        Route::get('/','index');
        Route::get('/{managerId}','show');
        Route::post('/','store');
        Route::post('/{managerId}','update');
        Route::delete('/{managerId}','destory');
    });

    Route::controller(HomeController::class)->group(function(){
        Route::get('/statistics','index');
    });
    Route::controller(ProfileController::class)->group(function(){
        Route::post('logout','logout');
        Route::get('refresh','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
        Route::get('/notifications','getAllNotificaitons');
        Route::get('/notifications-unread','getAllNotificaitonsUnread');
        Route::get('/notifications-mark','markNotificationsAsRead');
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

    Route::controller(ClientController::class)->prefix('/clients')->group(function(){
        Route::get('/','index');
        Route::get('/{clientId}','show');
        Route::post('/','store');
        Route::post('/{clientId}','update');
        Route::delete('/{clientId}','destory');
    });

    Route::controller(FaqController::class)->prefix('/faqs')->group(function(){
        Route::get('/','index');
        Route::get('/{faqId}','show');
        Route::post('/','store');
        Route::post('/{faqId}','update');
        Route::delete('/{faqId}','destory');
    });


    Route::controller(WhyUsController::class)->prefix('/whyus')->group(function(){
        Route::get('/','index');
        Route::get('/{whyUsId}','show');
        Route::post('/','store');
        Route::post('/{whyUsId}','update');
        Route::delete('/{whyUsId}','destory');
    });

    Route::controller(SettingController::class)->prefix('/settings')->group(function(){
        Route::get('/','index');
        Route::get('/{settingId}','show');
        Route::post('/{settingId}','update');
    });




    Route::controller(MessageController::class)->prefix('/messages')->group(function(){
        Route::get('/','index');
        Route::get('/{messageId}','show');
        Route::delete('/{messageId}','destory');
    });
});
