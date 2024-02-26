<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Models\Admin\UsefulLink;
use App\Models\UserNotification;
use App\Models\Admin\AppSettings;
use App\Models\DoctorAppointment;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Constants\PaymentGatewayConst;
use App\Models\Admin\DoctorHasSchedule;
use App\Models\Admin\TransactionSetting;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Support\Facades\Notification;
use App\Notifications\patientAppointmentNotification;

class AppointmentBookingController extends Controller
{
    /**
     * Method for show appointment booking page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function appointmentBooking($slug){

        $page_title                 = "| Appointment Booking";
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $doctor                     = Doctor::with(['schedules'])->where('slug',$slug)->first();
        if(!$doctor) abort(404);
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $validated_user             = auth()->user();
        $useful_links               = UsefulLink::where('status',true)->get();
       

        return view('frontend.pages.appointment-booking',compact(
            'page_title',
            'doctor',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
            'validated_user',
            'useful_links'
        ));
    }
    /**
     * Method for store appointment booking 
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function store(Request $request){
        $validator     = Validator::make($request->all(),[
            'doctor'   => 'required',
            'schedule' => 'required',
            'name'     => 'required|string',
            'phone'    => 'nullable',
            'email'    => 'required|email',
            'age'      => 'required|string',
            'age_type' => 'required|string',
            'type'     => 'required',
            'gender'   => 'required',
            'message'  => 'nullable',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput($request->all());
        }

        $validated          = $validator->validate();
        $age_type           = $request->age_type;
        $validated['age']   = $request->age.' '.$age_type;
        $validated['slug']  = Str::uuid();
        $slug               = $validated['doctor'];
        $find_doctor        = Doctor::where('slug',$slug)->first();
        if(!$find_doctor) return back()->with(['error' =>  ['Doctor not found!']]);

        $transaction_fees   = TransactionSetting::where('slug','appointment')->first();
        $amount             = floatval($find_doctor->fees);
        $fixed_charge       = $transaction_fees->fixed_charge;
        $percent_charge     = ($amount / 100) * $transaction_fees->percent_charge;
        $total_charge       = $fixed_charge + $percent_charge;
        $payable_amount     = $amount + floatval($total_charge);

        $data               = [
            'doctor_fees'   => $amount,
            'fixed_charge'  => floatval($fixed_charge),
            'percent_charge'=> floatval($percent_charge),
            'total_charge'  => floatval($total_charge),
            'payable_amount'=> floatval($payable_amount),
        ];

        if(auth()->check()){
            $validated['user_id']   = auth()->user()->id;
        }
        else{
            $validated['user_id']   = null;
        }

        $validated['doctor_id']   = $find_doctor->id;

        $schedule = DoctorHasSchedule::where('id',$validated['schedule'])->whereHas('doctor',function($q) use ($find_doctor) {
            $q->where('id',$find_doctor->id);
        })->first();

        if(!$schedule) {
            return back()->with(['error' => ['Schedule Not Found!']]);
        }

        $validated['schedule_id'] = $validated['schedule'];

        $alrady_appointed_patient = DoctorAppointment::where('doctor_id',$find_doctor->id)->where('schedule_id',$validated['schedule_id'])->count();

        if($alrady_appointed_patient >= $schedule->max_patient) {
            return back()->with(['error' => ['Appiontment Limit is over!']]);
        }

        $next_patient_appointment_no = $alrady_appointed_patient + 1;
        $validated['patient_number'] = $next_patient_appointment_no;
        $validated['details']        = $data;
        try{
           $patient_slug = DoctorAppointment::create($validated);
        }catch(Exception $e){
            return back()->with(['error' => ['Something Went Wrong! Please try again.']]);
        }
        return redirect()->route('frontend.appointment.booking.preview',$patient_slug->slug);
        
    }
    /** 
     * Method for show appointment preview page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function preview($slug){

        $page_title                 = "| Appointment Booking Preview";
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $patient                    = DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();
        $useful_links               = UsefulLink::where('status',true)->get();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $payment_gateway            = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::payment_method_slug());
            $gateway->where('status', 1);
        })->get();

        return view('frontend.pages.appointment-booking-preview',compact(
            'page_title',
            'contact',
            'patient',
            'footer',
            'app_settings',
            'useful_links',
            'news_letter',
            'payment_gateway'
        ));
    }
    /**
     * Method for Confirm patient appointment 
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function confirm($slug){
        
        $confirm_appointment = DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();

        if(!$confirm_appointment) return back()->with(['error' => ['Appointment not found!']]);

        $from_time        = $confirm_appointment->schedules->from_time ?? '';
        $parsed_from_time = Carbon::createFromFormat('H:i', $from_time)->format('h A');

        $to_time          = $confirm_appointment->schedules->to_time ?? '';
        $parsed_to_time   = Carbon::createFromFormat('H:i', $to_time)->format('h A');
        $form_data = [
            'name'               => $confirm_appointment->name,
            'email'              => $confirm_appointment->email,
            'phone'              => $confirm_appointment->phone,
            'type'               => $confirm_appointment->type,
            'gender'             => $confirm_appointment->gender,
            'schedule'           => $confirm_appointment->schedules->week->day,
            'doctor_name'        => $confirm_appointment->doctors->name,
            'doctor_speciality'  => $confirm_appointment->doctors->speciality,
            'from_time'          => $parsed_from_time,
            'to_time'            => $parsed_to_time,
            'serial_number'      => $confirm_appointment->patient_number,
            
        ];
        try{
            Notification::route("mail",$confirm_appointment->email)->notify(new patientAppointmentNotification($form_data));
            $confirm_appointment->update([
                'status'    => 1,
            ]);
            if(auth()->check()){
                UserNotification::create([
                    'user_id'  => auth()->user()->id,
                    'message'  => "Your appointment (Doctor: ".$confirm_appointment->doctors->name.",
                    Day: ".$confirm_appointment->schedules->week->day.", Time: ".$parsed_from_time."-".$parsed_to_time.", Serial Number: ".$confirm_appointment->patient_number.") Successfully booked.", 
                ]);
            }
        }
        catch(Exception $e){
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return redirect()->route('frontend.find.doctor')->with(['success' => ['Congratulations! Appointment Booking Confirmed Successfully.']]);

    }
}
