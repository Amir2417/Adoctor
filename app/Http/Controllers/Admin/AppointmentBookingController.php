<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\DoctorAppointment;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\websiteSubscribeNotification;
use Illuminate\Http\Request;

class AppointmentBookingController extends Controller
{
    public function index(){

        $page_title    = "Appointments";
        $booking_appointments = DoctorAppointment::with(['doctors'])->where('status',true)->orderByDesc("id")->paginate(10);

        return view('admin.sections.booking-appointment.index',compact(
            'page_title',
            'booking_appointments'
        ));
    }
    //method for reply mail
    public function reply(Request $request){
        $validator = Validator::make($request->all(),[
            'target'        => "required|integer|exists:doctor_appointments,id",
            'subject'       => "required|string|max:255",
            'message'       => "required|string|max:3000",
        ]);

        if($validator->fails()) return back()->withErrors($validator)->withInput()->with('modal','send-reply');
        $validated       = $validator->validate();
        $appointment_request = DoctorAppointment::find($validated['target']);
        // dd($appointment_request);
        try{
            Notification::route("mail",$appointment_request->email)->notify(new websiteSubscribeNotification($validated));
            UserNotification::create([
                'user_id'   => $appointment_request->user_id,
                'message'   => "An reply sent to your mail about your appointment(Doctor: ".$appointment_request->doctors->name.")",

            ]);
            
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['Reply sended successfully!']]);
    }


    public function bookingDetails($slug){
        $page_title       = "Booking Details";
        $appointment     = DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();
        // dd($appointments->doctors->image);

        return view('admin.sections.booking-appointment.view',compact(
            'page_title',
            'appointment'
        ));
    }
}
