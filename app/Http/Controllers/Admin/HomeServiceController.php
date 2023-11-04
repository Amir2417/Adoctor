<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\HomeTestService;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\websiteSubscribeNotification;

class HomeServiceController extends Controller
{
    public function index(){

        $page_title    = "Home Service";
        $booking_appointments = HomeTestService::where('status',true)->orderByDesc("id")->paginate(10);

        return view('admin.sections.home-service.index',compact(
            'page_title',
            'booking_appointments'
        ));
    }
    public function bookingDetails($slug){
        $page_title       = "Booking Details";
        $appointment     = HomeTestService::where('slug',$slug)->first();

        return view('admin.sections.home-service.view',compact(
            'page_title',
            'appointment'
        ));
    }

    public function reply(Request $request){
        $validator = Validator::make($request->all(),[
            'target'        => "required|integer|exists:home_test_services,id",
            'subject'       => "required|string|max:255",
            'message'       => "required|string|max:3000",
        ]);

        if($validator->fails()) return back()->withErrors($validator)->withInput()->with('modal','send-reply');
        $validated       = $validator->validate();
        $appointment_request = HomeTestService::find($validated['target']);
        // dd($appointment_request);
        try{
            Notification::route("mail",$appointment_request->email)->notify(new websiteSubscribeNotification($validated));
            UserNotification::create([
                'user_id'   => $appointment_request->id,
                'message'   => "An reply sent to your mail about your appointment",

            ]);
            
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['Reply sended successfully!']]);
    }
}
