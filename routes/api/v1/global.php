<?php

use App\Http\Controllers\Api\V1\SettingController;
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
    Route::get("/doctor/information","doctorInformation");
    Route::post("appointment/booking/store","appointmentBookingStore");
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