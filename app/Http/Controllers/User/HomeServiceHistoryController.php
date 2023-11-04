<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\HomeTestService;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeServiceHistoryController extends Controller
{
    /**
     * Method for show the home service history page
     */
    public function index(){
        $page_title           = "| Home Service";
        $breadcrumb           = "Home Service";
        $booking_appointments = HomeTestService::where('user_id',auth()->user()->id)->orderByDesc("id")->paginate(10);
        $user                 = auth()->user();
        $notifications        = UserNotification::where('user_id',$user->id)->latest()->take(10)->get();

        return view('user.sections.home-service.index',compact(
            'breadcrumb',
            'page_title',
            'booking_appointments',
            'user',
            'notifications'
        ));
    }
    /**
     * Method for home service details page
     */
    public function details($slug){
        $page_title = "| Booking Details";
        $booking    =  HomeTestService::where('slug',$slug)->first();
        // dd($booking);
        $user         = auth()->user();
        $notifications = UserNotification::where('user_id',$user->id)->latest()->take(10)->get();
        return view('user.sections.home-service.details',compact(
            'page_title',
            'booking',
            'user',
            'notifications'
        ));
    }
}
