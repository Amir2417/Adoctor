<?php

use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\User\AppointmentBookingController;
use App\Http\Controllers\Api\V1\User\BranchController;
use App\Http\Controllers\Api\V1\User\DashboardController;
use App\Http\Controllers\Api\V1\User\HealthPackageController;
use App\Http\Controllers\Api\V1\User\HomeServiceController;
use App\Http\Controllers\Api\V1\User\InvestigationController;
use Illuminate\Support\Facades\Route;

// Settings
Route::controller(SettingController::class)->prefix("settings")->group(function(){
    Route::get("basic/settings","basicSettings");
    Route::get("language","getLanguages");
    
});
Route::controller(DashboardController::class)->prefix("user")->group(function(){
    Route::get("dashboard","dashboard");
    Route::get("notifications","notifications");
    Route::get("doctor","doctor");
    Route::post("doctor/search","doctorSearch");
    
});

Route::controller(AppointmentBookingController::class)->prefix("user")->group(function(){
    Route::get("/doctor/information","doctorInformation");
    Route::post("appointment/booking/store","appointmentBookingStore");
    Route::get('payment-gateway','paymentGatewayList');
    Route::post('confirm','confirm');
});
Route::controller(AppointmentBookingController::class)->group(function(){
    // Automatic Gateway Response Routes
    Route::get('success/response/{gateway}','success')->withoutMiddleware(['auth:api'])->name("api.frontend.appointment.booking.payment.success");
    Route::get("cancel/response/{gateway}",'cancel')->withoutMiddleware(['auth:api'])->name("api.frontend.appointment.booking.payment.cancel");

    // POST Route For Unauthenticated Request ssl commerz
    Route::post('success/response/{gateway}', 'postSuccess')->name('payment.success')->withoutMiddleware(['auth:api']);
    Route::post('cancel/response/{gateway}', 'postCancel')->name('payment.cancel')->withoutMiddleware(['auth:api']);
});

Route::controller(HomeServiceController::class)->prefix("user")->group(function(){
    Route::post("home/service/store","store");
    Route::get("home/service","homeService");
});

//Investigation Controller

Route::controller(InvestigationController::class)->prefix("user")->group(function(){
    Route::get("investigation","investigation");
    Route::get("investigation/search","investigationSearch");
});

//health package

Route::controller(HealthPackageController::class)->prefix("user")->group(function(){
    Route::get("health/package","healthPackage");
    Route::get("health/package/search","healthPackageSearch");
});

//branch 

Route::controller(BranchController::class)->prefix("user")->group(function(){
    Route::get("branch","branch");
    route::get("branch/search","branchSearch");
});