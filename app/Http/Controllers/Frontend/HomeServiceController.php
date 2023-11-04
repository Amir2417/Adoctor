<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HomeTestService;
use App\Models\Admin\UsefulLink;
use App\Models\Admin\AppSettings;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\Investigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\homeServiceAppointmentNotification;

class HomeServiceController extends Controller
{
    /**
     * Method for show home service page
     */
    public function index(){
        $page_title                 = "| Home Services";
        $useful_links               = UsefulLink::where('status',true)->get();
        $hospital_tests             = Investigation::where('status',true)->where('home_service',true)->get();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        
        $dates       = [];
        $currentDate = Carbon::tomorrow();

        for ($i = 1; $i <= 5; $i++) {
            $dates[] = [
                'day'   => $currentDate->format('l'),      
                'month' => $currentDate->format('M'),  
                'Month' => $currentDate->format('F'),  
                'date'  => $currentDate->format('d'),
                'year'  => $currentDate->format('y'),
                'Year'  => $currentDate->format('Y'),
            ];
    
            $currentDate->addDay();
        }

        return view('frontend.pages.home_service',compact(
            'page_title',
            'useful_links',
            'dates',
            'hospital_tests',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
    /**
     * Method for store home service
     */
    public function store(Request $request){
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
            return back()->withErrors($validator)->withInput();
        }

        $validated          = $validator->validate();

        if(auth()->check()){
           
            $validated['user_id']   = auth()->user()->id;
            
          
        }
        else{
            $validated['user_id']   = null;
        }

        $age_type           = $request->age_type;
        $validated['age']   = $validated['age'].' '.$age_type;
        $validated['slug']  = Str::uuid();
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
            Notification::route("mail",$confirm_appointment->email)->notify(new homeServiceAppointmentNotification($form_data));
        }catch(Exception $e){
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' => ['Booking Confirm.']]);
    }
}
