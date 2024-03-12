<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Models\Admin\Journal;
use App\Http\Helpers\Response;
use App\Constants\LanguageConst;
use App\Models\Admin\SiteSections;
use App\Http\Controllers\Controller;
use App\Models\Admin\HospitalBranch;
use App\Models\Admin\BranchHasDepartment;
use App\Providers\Admin\CurrencyProvider;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request){
        
        $lang = $request->language;
        $default = LanguageConst::NOT_REMOVABLE;
        

        $journals  = Journal::where('status',true)->orderByDesc("id")->latest()->take(10)->get()->map(function($data) use($lang,$default){
            $title       = isset($data->data->language->$lang) ? $data->data->language->$lang->title : $data->data->language->$default->title;

            
            $description = isset($data->data->language->$lang) ? $data->data->language->$lang->description : $data->data->language->$default->description;
            $tags        = isset($data->data->language->$lang) ? $data->data->language->$lang->tags : $data->data->language->$default->tags;  

            

            return[
                'id'           => $data->id,
                'slug'         => $data->slug,
                'title'        => $title,
                'image'        => $data->data->image,
                'description'  => $description,
                'tags'         => $tags,
                'status'       => $data->status,
                'created_at'   => $data->created_at,
                'updated_at'   => $data->updated_at,
            ];
            
        });

        //filters 

        $branch   = HospitalBranch::where('status',true)->orderBy("id")->get()->map(function($item){
            return [
                'id'   => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'status' => $item->status,
                'last_edit_by' => $item->last_edit_by,
                'created_at'   => $item->created_at,
            ];
        });

        
        $branch_has_department = BranchHasDepartment::orderBy("id")->get()->map(function($item){
            return [
                'id'                      => $item->id,
                'hospital_branch_id'      => $item->hospital_branch_id,
                'hospital_department_id'  => $item->hospital_department_id,
                'hospital_department_name'         => $item->department->name,
                'hospital_department_slug'         => $item->department->slug,
                'created_at'              => $item->created_at,
            ];
        });
        
        

        

        $image_paths = [
            'base_url'         => url("/"),
            'path_location'    => files_asset_path_basename("site-section"),
            'default_image'    => files_asset_path_basename("default"),
            
        ];

        // Testimonial Data
        $testimonial =  SiteSections::where('key', 'testimonial-section')->first();
        if(isset($testimonial->value->items)){
            $testimonial_items = $testimonial->value->items;
            
            $testimonials = [];
            foreach ($testimonial_items ?? [] as $key => $value) {
                $comment = isset($value->language->$lang) ? $value->language->$lang->comment : $value->language->$default->comment;
               
                $testimonials[] = [
                    'id'      => $value->id,
                    'name'      => $value->name,
                    'designation' => $value->designation,
                    'image'      => $value->image,
                    'created_at'  => $value->created_at,
                    'comment'   => $comment,
                ]; 
            }

        }else{
            $testimonials = null;
        }
        // web links

        $journal_page_link   = route('journals');
        
        //doctor list
        $doctors  = Doctor::with(['branch','department'])->where("status",true)->orderBy("id")->get()->map(function($data){
            return [
                'id'                  => $data->id,
                'hospital_branch'     => $data->branch->name,
                'hospital_department' => $data->department->name,
                'name'                => $data->name,
                'slug'                => $data->slug,
                'doctor_title'        => $data->doctor_title,
                'qualification'       => $data->qualification,
                'speciality'          => $data->speciality,
                'language'            => $data->language,
                'designation'         => $data->designation,
                'contact'             => $data->contact,
                'floor_number'        => $data->floor_number,
                'room_number'         => $data->room_number,
                'address'             => $data->address,
                'fees'                => get_amount($data->fees).' '.CurrencyProvider::default()->code,
                'off_days'            => $data->off_days,
                'image'               => $data->image,
                'status'              => $data->status,                
                'created_at'          => $data->created_at,
            ];
        });
        $doctor_image_paths = [
            'base_url'         => url("/"),
            'path_location'    => files_asset_path_basename("site-section"),
            'default_image'    => files_asset_path_basename("default"),
            
        ];
       
        $web_links =[
            [
                'name' => "Journal Page",
                'link' => $journal_page_link,
            ]
        ];
        return Response::success(['Dashboard data fetch successfully!'],[ 
            "journal"     => $journals,
            'testimonial' => $testimonials,
            'branch'      => $branch,
            'branch_has_department' => $branch_has_department,
            'doctor_list'   => $doctors,
            "doctor_image_paths" => $doctor_image_paths,
            'web_links'     => $web_links, 
            "image_paths" => $image_paths,
        ],200);
    }
    //doctor list
    public function doctor(Request $request){
        if($request->branch && $request->department){
            $doctors  = Doctor::with(['branch','department'])->where("status",true)->where('hospital_branch_id',$request->branch)->where('hospital_department_id',$request->department)->orderBy("id")->get()->map(function($data){
                return [
                    'id'                  => $data->id,
                    'hospital_branch'     => $data->branch->name,
                    'hospital_department' => $data->department->name,
                    'name'                => $data->name,
                    'slug'                => $data->slug,
                    'doctor_title'        => $data->doctor_title,
                    'qualification'       => $data->qualification,
                    'speciality'          => $data->speciality,
                    'language'            => $data->language,
                    'designation'         => $data->designation,
                    'contact'             => $data->contact,
                    'floor_number'        => $data->floor_number,
                    'room_number'         => $data->room_number,
                    'address'             => $data->address,
                    'fees'                => get_amount($data->fees).' '.CurrencyProvider::default()->code,
                    'off_days'            => $data->off_days,
                    'image'               => $data->image,
                    'status'              => $data->status,                
                    'created_at'          => $data->created_at,
                ];
            });
        }else{
            $doctors  = Doctor::with(['branch','department'])->where("status",true)->orderBy("id")->get()->map(function($data){
                return [
                    'id'                  => $data->id,
                    'hospital_branch'     => $data->branch->name,
                    'hospital_department' => $data->department->name,
                    'name'                => $data->name,
                    'slug'                => $data->slug,
                    'doctor_title'        => $data->doctor_title,
                    'qualification'       => $data->qualification,
                    'speciality'          => $data->speciality,
                    'language'            => $data->language,
                    'designation'         => $data->designation,
                    'contact'             => $data->contact,
                    'floor_number'        => $data->floor_number,
                    'room_number'         => $data->room_number,
                    'address'             => $data->address,
                    'fees'                => get_amount($data->fees).' '.CurrencyProvider::default()->code,
                    'off_days'            => $data->off_days,
                    'image'               => $data->image,
                    'status'              => $data->status,                
                    'created_at'          => $data->created_at,
                ];
            });
        }
        
        $image_paths = [
            'base_url'         => url("/"),
            'path_location'    => files_asset_path_basename("site-section"),
            'default_image'    => files_asset_path_basename("default"),
            
        ];

        return Response::success(['Doctor Data fetch Successfully.'],[
            'doctors'     => $doctors,
            'image_asset' => $image_paths,
        ],200);
    }
    //search doctor
    public function doctorSearch(Request $request){
        
        $validator = Validator::make($request->all(),[
            'branch'       => 'nullable',
            'department'   => 'nullable',
            'doctor'       => 'nullable',
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors()->all(),[]);
        }
        if($request->branch != null && $request->department != null && $request->doctor != null){
            
            $doctors    = Doctor::where('hospital_branch_id',$request->branch)->where('hospital_department_id',$request->department)->where('name','like','%'.$request->doctor.'%')->get(); 
        }else if($request->branch && $request->department){
            $doctors    = Doctor::where('hospital_branch_id',$request->branch)->where('hospital_department_id',$request->department)->get();
        }else{
            $doctors    = Doctor::where('name','like','%'.$request->doctor.'%')->get();
        }
        if ($doctors->isEmpty()) {
            return Response::error(['Doctor not found!'],[],404);
        }

        return Response::success(['Doctor Find Successfully!'],$doctors,200);  
    }
    
}
