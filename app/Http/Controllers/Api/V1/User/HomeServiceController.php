<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\HomeTestService;
use App\Http\Controllers\Controller;
use App\Models\Admin\Investigation;
use Illuminate\Support\Facades\Validator;
use App\Notifications\homeServiceAppointmentNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class HomeServiceController extends Controller
{
    public function store(Request $request){
        // dd($request->all());
        $validator     = Validator::make($request->all(),[
            'name'   => 'required',
            'phone'    => 'nullable',
            'email'    => 'required|email',
            'type'     => 'required',
            'age'      => 'required|string',
            'age_type' => 'required|string',
            'gender'   => 'required',
            'address'  => 'required',
            'schedule' => 'required|string',
            'message'  => 'nullable',
            
        ]);

        
        if($validator->fails()){
            return Response::error($validator->errors()->all(),[]);
        }

        $validated          = $validator->validate();
        
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
            
            $validated['status']    = true;
        }
        else{
            $validated['user_id']   = null;
        }
        $age_type           = $request->age_type;
        $validated['age']   = $validated['age'].' '.$age_type;
        $validated['slug']  = Str::uuid();
        $validated['type']  = [$validated['type']];

        // dd($validated['type']);
        try{
            $confirm_appointment = HomeTestService::create($validated);
            $type  = implode(', ',$confirm_appointment->type ?? []);
            $form_data = [
                'name'               => $confirm_appointment->name,
                'email'              => $confirm_appointment->email,
                'phone'              => $confirm_appointment->phone,
                'schedule'           => $confirm_appointment->schedule,
                'type'               => $type,
                'gender'             => $confirm_appointment->gender,
                'address'            => $confirm_appointment->address,
                'message'            => $confirm_appointment->message,
               
            ];
            // dd($form_data);
            Notification::route("mail",$confirm_appointment->email)->notify(new homeServiceAppointmentNotification($form_data));
        }catch(Exception $e){
            return Response::error(['Something went wrong! Please try again.'],[],404);
        }
        return Response::success(['Appointment booking successfully'],[],200);

    }

    //Home Service

    public function homeService(){
        $dates       = [];
        $currentDate = Carbon::tomorrow();

        for ($i = 1; $i <= 5; $i++) {
            $dates[] = [
                'day'   => $currentDate->format('l'),       
                'date'  => $currentDate->format('d'),
                'Month' => $currentDate->format('F'),  
                'Year'  => $currentDate->format('Y'),
            ];
    
            $currentDate->addDay();
        }

        $home_service_test  = Investigation::where("home_service",true)->orderBy("id")->get()->map(function($data){
            return [
                'id'           => $data->id,
                'name'         => $data->name,
                'slug'         => $data->slug,
                'price'        => $data->price,
                'offer_price'  => $data->offer_price,
                'status'       => $data->status,
                'last_edit_by' => $data->last_edit_by,
                'created_at'   => $data->created_at,
            ];
        });

        return Response::success(['Next Five Days'],[
            'schedules' => $dates,
            'types' => $home_service_test,
        ],200);
    }
}
