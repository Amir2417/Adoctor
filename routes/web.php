<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\SiteController;
use App\Http\Controllers\Frontend\BranchController;
use App\Http\Controllers\Frontend\HomeServiceController;
use App\Http\Controllers\Frontend\HealthPackageController;
use App\Http\Controllers\Frontend\InvestigationController;
use App\Http\Controllers\Frontend\AppointmentBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(SiteController::class)->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/about','about')->name('about');
    Route::get('/faq','faqs');
    Route::get('/journals','journals')->name("journals");
    Route::get('/contact','contact');
    Route::post('get/branch/departments','getBranchDepartments')->name('get.branch.departments');
    Route::post("subscribe",'subscribe')->name("subscribe");
    Route::post("contact-request",'contactRequest')->name("contact.request");
    Route::get('link/{slug}','link')->name('link');
});

Route::controller(SiteController::class)->name("frontend.")->group(function(){

    Route::get('/find-doctors','doctors')->name("find.doctor");
    Route::get('/journal-details/{slug}','journalDetails')->name("journal.details");
    Route::get('search/doctor','searchDoctor')->name('doctor.search');

    // appointment booking 
    Route::controller(AppointmentBookingController::class)->name('appointment.booking.')->group(function(){
        Route::get('/appointment-booking/{slug}','appointmentBooking')->name('index');
        Route::post('store','store')->name('store');
        Route::get('preview/{slug}','preview')->name('preview');
        Route::get('confirm/{slug}','confirm')->name('confirm');
    });

    //investigation
    Route::controller(InvestigationController::class)->prefix('investigation')->name('investigation.')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('search','search')->name('search');
    });

    //branch
    Route::controller(BranchController::class)->prefix('branch')->name('branch.')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('search','search')->name('search');
    });

    //health-package
    Route::controller(HealthPackageController::class)->prefix('health-package')->name('health.package.')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('search','search')->name('search');
    });

    //home-service
    Route::controller(HomeServiceController::class)->prefix('home-service')->name('home.service.')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('store','store')->name('store');
    });

});




