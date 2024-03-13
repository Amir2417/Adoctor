<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Http\Helpers\Response;
use App\Models\UserNotification;
use App\Models\DoctorAppointment;
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
     //doctor Information
     public function doctorInformation(Request $request){
        
        $doctor       = Doctor::with(['schedules'])->where('slug',$request->slug)->first();
        if(!$doctor){
            return Response::error(['Doctor Not exists!'],[],404);
        }
        
        
        $doctor_info = [
            'name'            => $doctor->name,
            'slug'            => $doctor->slug,
            'doctor_title'    => $doctor->doctor_title,
            'image'           => $doctor->image,
            'qualification'   => $doctor->qualification,
            'speciality'      => $doctor->speciality,
            'language'        => $doctor->language,
            'designation'     => $doctor->designation,
            'department'      => $doctor['department']['name'],
            'contact'         => $doctor->contact,
            'off_days'        => $doctor->off_days,
            'floor_number'    => $doctor->floor_number,
            'room_number'     => $doctor->room_number,
            'branch'          => $doctor['branch']['name'],
            'address'         => $doctor->address,
            'fees'            => get_amount($doctor->fees),
            'currency_code'   => get_default_currency_code(),
        ];

        
        if(isset($doctor->schedules)){
            $schedule_items = $doctor->schedules;
            $schedule = [];
            foreach ($schedule_items ?? [] as $key => $value) {
                $originalDate = $value->created_at;
                $formattedDate = Carbon::parse($originalDate);
                    
                $date  = $formattedDate->format('d');    
                $month = $formattedDate->format('F');  
                $year  = $formattedDate->format('Y');  
                $schedule[] = [
                    'id'            => $value->id,
                    'day'           => $value->week->day,
                    'from_time'     => $value->from_time,
                    'to_time'       => $value->to_time,
                    'date'          => $date,
                    'month'         => $month,
                    'year'          => $year,
                ]; 
            }

        }else{
            $schedule = null;
        }

        $image_paths = [
            'base_url'         => url("/"),
            'path_location'    => files_asset_path_basename("site-section"),
            'default_image'    => files_asset_path_basename("default"),
            
        ];
        return Response::success(['Doctor Information Fetch Successfully!'],[ 
            "info"        => $doctor_info,
            'schedule'     => $schedule, 
            'image_asset' => $image_paths,
            
        ],200);
    }



    //appointment booking store
    public function appointmentBookingStore(Request $request){
        $validator     = Validator::make($request->all(),[
            'doctor'   => 'required',
            'schedule' => 'required',
            'name'     => 'required|string',
            'phone'    => 'nullable',
            'email'    => 'required|email',
            'age'      => 'required|string',
            'type'     => 'required',
            'gender'   => 'required',
        ]);

        if($validator->fails()){
            return Response::error($validator->errors()->all(),[]);
        }

        $validated          = $validator->validate();

        $slug                = $validated['doctor'];
        $validated['slug']   = Str::uuid();
        $find_doctor         = Doctor::where('slug',$slug)->first();
        if(!$find_doctor) return Response::error(['Doctor Not found!'],404);
        
        $transaction_fees   = TransactionSetting::where('slug','appointment')->first();
        if(!$transaction_fees){
            return Response::error(['Transaction data not found!'],404);
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
        if(auth()->guard("api")->check()){
            if(isset(auth()->user()->date_of_birth)){
                $dateOfBirth = Carbon::createFromFormat('d-m-Y', auth()->user()->date_of_birth);
                $ages = $dateOfBirth->diff(Carbon::now());
        
                if($ages->y > 0){
                    $age = "{$ages->y} Years";
                }elseif($ages->m > 0){
                    $age = "{$ages->m} Months";
                }else{
                    $age = "{$ages} Days";
                }  

            }
            $validated['user_id']   = auth()->guard("api")->user()->id;
            $validated['site_type'] = global_const()::API;
            $validated['authenticated'] = true;
    
        }
        else{
            $validated['user_id']   = null;
            $validated['site_type'] = global_const()::API;
            $validated['authenticated'] = false;
        }

        $validated['doctor_id']   = $find_doctor->id;

        $schedule = DoctorHasSchedule::where('id',$validated['schedule'])->whereHas('doctor',function($q) use ($find_doctor) {
            $q->where('id',$find_doctor->id);
        })->first();

        if(!$schedule) {
            return Response::error(['Schedule not found!'],404);
        }

        $validated['schedule_id'] = $validated['schedule'];

        $already_appointed_patient = DoctorAppointment::where('doctor_id',$find_doctor->id)->where('schedule_id',$validated['schedule_id'])->count();

        if($already_appointed_patient >= $schedule->max_patient) {
            Response::error(['Appointment limit is over!'],404);
        }

        $next_patient_appointment_no = $already_appointed_patient + 1;
        $validated['patient_number'] = $next_patient_appointment_no;
        $validated['details']        = $data;
        try{
            $confirm_appointment = DoctorAppointment::create($validated);
            
        }catch(Exception $e){
            return Response::error(['Something went wrong! Please try again.'],[],404);
        }
        return Response::success(['Your booking is under pending.'],$confirm_appointment,200);

    }
    /**
     * Method for payment gateway list
     * @return response
     */
    public function paymentGatewayList(){
        $payment_gateway   = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::payment_method_slug());
            $gateway->where('status', 1);
        })->get();
        $image_path  = [
            'base_url'                     => url("/"),
            'path_location'                => files_asset_path_basename("payment-gateways"),
            'default_image'                => files_asset_path_basename("default"),
        ];
        return Response::success([__('Payment Method Data Fetch Successfully.')],[
            'payment_gateway' => $payment_gateway,
            'image_path'      => $image_path,
        ],200);
    }
    /**
     * Method for confirm appointment booking
     * @param \Illuminate\Http\Request 
     */
    public function confirm(Request $request){
        $validator           = Validator::make($request->all(),[
            'payment_method' => 'required',
            'slug'     => 'required'
        ]);
        if($validator->fails()){
            return Response::error($validator->errors()->all(),[]);
        }
        $validated      = $validator->validate();

        $confirm_appointment = DoctorAppointment::with(['doctors','schedules'])->where('slug',$validated['slug'])->first();

        if(!$confirm_appointment) return Response::error(['Appointment not found!'],404);

        $from_time        = $confirm_appointment->schedules->from_time ?? '';
        $parsed_from_time = Carbon::createFromFormat('H:i', $from_time)->format('h A');

        $to_time          = $confirm_appointment->schedules->to_time ?? '';
        $parsed_to_time   = Carbon::createFromFormat('H:i', $to_time)->format('h A');
        $basic_setting    = BasicSettings::first();

        if($validated['payment_method'] == global_const()::CASH_PAYMENT){
            $data                   = [
                'doctor_fees'       => $confirm_appointment->details->doctor_fees,
                'fixed_charge'      => $confirm_appointment->details->fixed_charge,
                'percent_charge'    => $confirm_appointment->details->percent_charge,
                'total_charge'      => $confirm_appointment->details->total_charge,
                'payable_amount'    => $confirm_appointment->details->payable_amount,
                'payment_method'    => $validated['payment_method'],
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
                
                return Response::error(['Something went wrong! Please try again.'],404);
            }
            return Response::success([__('Appointment booking successfull')],[
                'data' => $confirm_appointment,
            ],200);
        }else{
            $request_data           = [
                'identifier'        => $confirm_appointment->slug,
                'payment_method'    => $validated['payment_method'],
            ];
            try{
                
                $instance = PaymentGatewayHelper::init($request_data)->gateway()->api()->render();
            }catch(Exception $e){
                return Response::error([__('Can\'t submit manual gateway in automatic link')],[],400);
            }
            return Response::success([__('Payment gateway response successful')],[
                'redirect_url'          => $instance['redirect_url'],
            ],200);
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
            $booking_data = DoctorAppointment::where('slug',$temp_data->data->user_record)->where('status',false)->first();
            $booking_data_confirm = DoctorAppointment::where('slug',$temp_data->data->user_record)->where('status',true)->first();
            
            if($booking_data_confirm) return Response::error([__('Already confirm the booking.')],[],400);
            if(!$temp_data){
                
                if(DoctorAppointment::where('callback_ref', $token)->exists()) {
                    return Response::success([__('Transaction request sended successfully!')],[],400);
                }else {
                    return Response::error([__('Transaction failed. Record didn\'t saved properly. Please try again')],[],400);
                }
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
            return Response::error([$e->getMessage()],[],500);
        }
        return Response::success(["Payment successful, please go back your app"],[
            'authenticated' => floatval($booking_data->authenticated)
        ],200);
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
            return Response::error([$e->getMessage()]);
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
            return Response::error([$e->getMessage()]);
        }
        return $this->cancel($request, $gateway);
    }
}
