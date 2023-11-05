<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\DoctorAppointment;
use App\Http\Controllers\Controller;
use App\Notifications\prescriptionNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\websiteSubscribeNotification;

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
        $appointment      = DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();
        

        return view('admin.sections.booking-appointment.view',compact(
            'page_title',
            'appointment'
        ));
    }
    /**
     * Method for upload prescription file
     */
    public function prescriptionUpload(Request $request,$slug){
        $data           = DoctorAppointment::with(['doctors','schedules','user'])->where('slug',$slug)->first();
        $validator      = Validator::make($request->all(),[
            'prescription'      => 'required',
        ]);
        $validated      = $validator->validate();
        
        try{
            if($request->hasFile('prescription')) {
                $file_name = 'prescription-'.Carbon::parse(now())->format("Y-m-d") . "." .$validated['prescription']->getClientOriginalExtension();
                $file_link = get_files_path('prescription-file') . '/' . $file_name;
                
                (new Filesystem)->cleanDirectory(get_files_path('prescription-file'));
                File::move($validated['prescription'],$file_link);
                $data->update([
                    'prescription'      => $file_name,
                ]);
                UserNotification::create([
                    'user_id'   => $data->user_id,
                    'message'   => "Prescription sent for (Patient:" .$data->name .")". "(Doctor: ".$data->doctors->name.")",
    
                ]);
                $prescription   = get_files_path('prescription-file') . '/' . $data->prescription;
                
                Notification::route("mail",$data->user->email)->notify(new prescriptionNotification($prescription));
            }
            
        }catch(Exception $e){
            
            return back()->with(['error'  => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success'  => ['File Uploaded Successfully.']]);
    }
    /**
     * Method for download prescription
     */
    public function downloadPrescription($slug)
    {
        $data = DoctorAppointment::where('slug', $slug)->first();
        if ($data) {
            $file = get_files_path('prescription-file') . '/' . $data->prescription;
            if (file_exists($file)) {
                return response()->download($file, $data->prescription);
            } else {
                return "File not found in storage: " . $file;
            }
        }
    }
}