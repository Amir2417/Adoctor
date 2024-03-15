<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\DoctorAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Method for show history page
     */
    public function index(){
        $breadcrumb    = "History";
        $page_title    = "| User History";
        $booking       = DoctorAppointment::with(['doctors','schedules','user'])->where('user_id',auth::user()->id)->orderBy('id','desc')->paginate(6);
        $user          = auth()->user();
        $notifications = UserNotification::where('user_id',$user->id)->latest()->take(10)->get();
        return view('user.sections.history.index',compact(
            'breadcrumb',
            'page_title',
            'booking',
            'user',
            'notifications'
        ));
    }
    /**
     * Method for view the history details Page
     */
    public function bookingDetails($slug){
        $page_title    = "| Booking Details";
        $breadcrumb    = "Booking Details";
        $booking       =  DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();
        $user          = auth()->user();
        $notifications = UserNotification::where('user_id',$user->id)->latest()->take(10)->get();

        
        return view('user.sections.history.details',compact(
            'page_title',
            'breadcrumb',
            'booking',
            'user',
            'notifications'
        ));
        
    }
    /**
     * Method for download prescription
     */
    public function downloadPrescription($slug){
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
