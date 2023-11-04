<?php

use App\Http\Controllers\Api\V1\User\MoneyTransferController;
use App\Http\Controllers\Api\V1\User\AddMoneyController;
use App\Http\Controllers\Api\V1\User\BranchController;
use App\Http\Controllers\Api\V1\User\DashboardController;
use App\Http\Controllers\Api\V1\User\HealthPackageController;
use App\Http\Controllers\Api\V1\User\HomeServiceController;
use App\Http\Controllers\Api\V1\User\InvestigationController;
// use App\Http\Controllers\Api\V1\User\MakePaymentController;
// use App\Http\Controllers\Api\V1\User\MoneyExchangeController;
// use App\Http\Controllers\Api\V1\User\MoneyOutController;
use App\Http\Controllers\Api\V1\User\ProfileController;
// use App\Http\Controllers\Api\V1\User\TransactionController;
// use App\Http\Controllers\Api\V1\User\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::prefix("user")->name("api.user.")->group(function(){



    Route::controller(ProfileController::class)->prefix('profile')->group(function(){
        Route::get('info','profileInfo');
        Route::post('info/update','profileInfoUpdate');
        Route::post('password/update','profilePasswordUpdate');
    });



    // Logout Route
    Route::post('logout',[ProfileController::class,'logout']);



    // // Dashboard, Notification, 
    // Route::controller(DashboardController::class)->group(function(){
    //     Route::get("dashboard","dashboard");
    //     Route::get("notifications","notifications");
    //     Route::get("doctor","doctor");
    //     Route::post("doctor/search","doctorSearch");
    //     Route::get("/doctor/information","doctorInformation");
    //     // Route::post("appointment/booking/store","appointmentBookingStore");
    // });

    //Investigation Controller

    Route::controller(InvestigationController::class)->group(function(){
        Route::get("investigation","investigation");
        Route::get("investigation/search","investigationSearch");
    });

    //health package

    Route::controller(HealthPackageController::class)->group(function(){
        Route::get("health/package","healthPackage");
        Route::get("health/package/search","healthPackageSearch");
    });

    //branch 

    Route::controller(BranchController::class)->group(function(){
        Route::get("branch","branch");
        route::get("branch/search","branchSearch");
    });

    //History

    Route::controller(ProfileController::class)->group(function(){
        Route::get("history","history");
        Route::get("home-service-history","homeServiceHistory");
    });

   
    
});

