<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Http\Helpers\Response;
use App\Models\Admin\UsefulLink;
use App\Models\UserNotification;
use App\Models\Admin\AppSettings;
use App\Models\DoctorAppointment;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Constants\PaymentGatewayConst;
use App\Models\Admin\DoctorHasSchedule;
use App\Models\Admin\TransactionSetting;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Support\Facades\Notification;
use App\Notifications\patientAppointmentNotification;
use App\Http\Helpers\PaymentGateway as PaymentGatewayHelper;

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
        if(!$transaction_fees){
            return back()->with(['error' => [__('Transaction data not found!')]]);
        }
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
            $validated['site_type'] = global_const()::WEB;
            $validated['authenticated'] = true;
        }
        else{
            $validated['user_id']       = null;
            $validated['site_type']     = global_const()::WEB;
            $validated['authenticated'] = false;
        }

        $validated['doctor_id']   = $find_doctor->id;

        $schedule = DoctorHasSchedule::where('id',$validated['schedule'])->whereHas('doctor',function($q) use ($find_doctor) {
            $q->where('id',$find_doctor->id);
        })->first();

        if(!$schedule) {
            return back()->with(['error' => ['Schedule Not Found!']]);
        }

        $validated['schedule_id'] = $validated['schedule'];

        $already_appointed_patient = DoctorAppointment::where('doctor_id',$find_doctor->id)->where('schedule_id',$validated['schedule_id'])->count();

        if($already_appointed_patient >= $schedule->max_patient) {
            return back()->with(['error' => ['Appiontment Limit is over!']]);
        }

        $next_patient_appointment_no = $already_appointed_patient + 1;
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
    public function confirm(Request $request,$slug){

        $confirm_appointment = DoctorAppointment::with(['doctors','schedules'])->where('slug',$slug)->first();

        if(!$confirm_appointment) return back()->with(['error' => ['Appointment not found!']]);

        $from_time        = $confirm_appointment->schedules->from_time ?? '';
        $parsed_from_time = Carbon::createFromFormat('H:i', $from_time)->format('h A');

        $to_time          = $confirm_appointment->schedules->to_time ?? '';
        $parsed_to_time   = Carbon::createFromFormat('H:i', $to_time)->format('h A');
        $basic_setting    = BasicSettings::first();

        if($request->selected_payment_method == global_const()::CASH_PAYMENT){
            $validator           = Validator::make($request->all(),[
                'selected_payment_method' => 'required'
            ]);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput($request->all());
            }
            $validated          = $validator->validate();
            $data                   = [
                'doctor_fees'       => $confirm_appointment->details->doctor_fees,
                'fixed_charge'      => $confirm_appointment->details->fixed_charge,
                'percent_charge'    => $confirm_appointment->details->percent_charge,
                'total_charge'      => $confirm_appointment->details->total_charge,
                'payable_amount'    => $confirm_appointment->details->payable_amount,
                'payment_method'    => $validated['selected_payment_method'],
                'currency'          => get_default_currency_code(),
            ];
            
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
                if($basic_setting->email_notification == true){
                    Notification::route("mail",$confirm_appointment->email)->notify(new patientAppointmentNotification($form_data));
                }
                $confirm_appointment->update([
                    'status'    => 1,
                    'details'   => $data,
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
        }else{
            $validator           = Validator::make($request->all(),[
                'payment_method' => 'required'
            ]);
            $validated              = $validator->validate();

            $request_data           = [
                'identifier'        => $confirm_appointment->slug,
                'payment_method'    => $validated['payment_method'],
            ];
            try{
                $instance = PaymentGatewayHelper::init($request_data)->gateway()->render();
            }catch(Exception $e){
                return back()->with(['error' => [$e->getMessage()]]);
            }
            return $instance;
        }
    }
    /**
     * Method for appointment booking success
     * @param $gateway
     * @param \Illuminate\Http\Request $request
     */
    public function success(Request $request, $gateway){
        try{
            $token = PaymentGatewayHelper::getToken($request->all(),$gateway);
            
            $temp_data = TemporaryData::where("identifier",$token)->first();
            $booking_data = DoctorAppointment::where('slug',$temp_data->data->user_record)->first();

            if(DoctorAppointment::where('callback_ref', $token)->exists()) {
                if(!$temp_data) return redirect()->route('frontend.find.doctor')->with(['success' => ['Congratulations! Appointment Booking Confirmed Successfully.']]);;
            }else {
                if(!$temp_data) return redirect()->route('frontend.find.doctor')->with(['error' => ['Booking failed. Record didn\'t saved properly. Please try again.']]);
            }
            
            $update_temp_data = json_decode(json_encode($temp_data->data),true);
            $update_temp_data['callback_data']  = $request->all();
            $temp_data->update([
                'data'  => $update_temp_data,
            ]);
            $temp_data = $temp_data->toArray();
            
            $instance = PaymentGatewayHelper::init($temp_data)->responseReceive();
            
          
            if($instance instanceof RedirectResponse) return $instance;
        }catch(Exception $e) {
            return redirect()->route("frontend.find.doctor")->with(['error' => [$e->getMessage()]]);
        }
       
        if($booking_data->site_type == global_const()::WEB){
            return redirect()->route("frontend.find.doctor")->with(['success' => ['Congratulations! Appointment Booking Confirmed Successfully.']]);
        }else{
            return Response::success(["Payment successful, please go back your app"],[
                'authenticated'     => floatval($booking_data->authenticated),
            ],200);
        }
    }
    public function cancel(Request $request, $gateway) {
        if($request->has('token')) {
            $identifier = $request->token;
            if($temp_data = TemporaryData::where('identifier', $identifier)->first()) {
                $temp_data->delete();
            }
        }
        return redirect()->route('frontend.find.doctor');
    }
    /**
     * Method for buy crypto SSL Commerz Success
     * @param $gateway
     * @param \Illuminate\Http\Request $request
     */
    public function postSuccess(Request $request, $gateway)
    {
        try{
            $token = PaymentGatewayHelper::getToken($request->all(),$gateway);
            $temp_data = TemporaryData::where("identifier",$token)->first();
            
            // Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
        }catch(Exception $e) {
            return redirect()->route('index');
        }
        return $this->success($request, $gateway);
    }
    /**
     * Method for buy crypto SSL Commerz Cancel
     * @param $gateway
     * @param \Illuminate\Http\Request $request
     */
    public function postCancel(Request $request, $gateway)
    {
        try{
            $token = PaymentGatewayHelper::getToken($request->all(),$gateway);
            $temp_data = TemporaryData::where("identifier",$token)->first();
            Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
        }catch(Exception $e) {
            return redirect()->route('index');
        }
        return $this->cancel($request, $gateway);
    }
    /**
     * Method for buy crypto Callback
     * @param $gateway
     * @param \Illuminate\Http\Request $request
     */
    public function callback(Request $request,$gateway) {

        $callback_token = $request->get('token');
        $callback_data = $request->all();

        try{
            PaymentGatewayHelper::init([])->handleCallback($callback_token,$callback_data,$gateway);
        }catch(Exception $e) {
            logger($e);
        }
    }
    /**
     * Redirect Users for collecting payment via Button Pay (JS Checkout)
     */
    public function redirectBtnPay(Request $request, $gateway)
    {
        try{
            return PaymentGatewayHelper::init([])->handleBtnPay($gateway, $request->all());
        }catch(Exception $e) {
            return redirect()->route('index')->with(['error' => [$e->getMessage()]]);
        }
    }
    /**
     * Method for buy crypto redirect html form
     */
    public function redirectUsingHTMLForm(Request $request, $gateway)
    {
        $temp_data = TemporaryData::where('identifier', $request->token)->first();
        
        if(!$temp_data || $temp_data->data->action_type != PaymentGatewayConst::REDIRECT_USING_HTML_FORM) return back()->with(['error' => ['Request token is invalid!']]);
        $redirect_form_data = $temp_data->data->redirect_form_data;
        $action_url         = $temp_data->data->action_url;
        $form_method        = $temp_data->data->form_method;
        
        return view('payment-gateway.redirect-form', compact('redirect_form_data', 'action_url', 'form_method'));
    }
}
