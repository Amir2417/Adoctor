<?php

namespace App\Http\Controllers\Admin;
use Exception;
use App\Models\Admin\Week;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Admin\HospitalBranch;
use App\Models\Admin\BranchHasDepartment;
use App\Models\Admin\DoctorHasSchedule;
use App\Models\Admin\HospitalDepartment;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DoctorCareController extends Controller
{
    /**
     * Method for show doctor-care index page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function index(){

        $page_title = "Doctors";
        $doctors    = Doctor::get();

        return view('admin.sections.doctor-care.index',compact(
            'page_title',
            'doctors'
        ));
    }
    /**
     * Method for show doctor-care create page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function create(){

        $page_title      = "Doctor Create";
        $weeks           = Week::get();
        $hospital_branch = HospitalBranch::orderBy('name','ASC')->get();
        // $doctor          = Doctor::


        return view('admin.sections.doctor-care.create',compact(
            'page_title',
            'hospital_branch',
            'weeks',
         
        ));
    }
    /**
     * Method for get all departments based on branch
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function getBranchDepartments(Request $request) {

        $validator    = Validator::make($request->all(),[
            'branch'  => 'required|integer',           
        ]);
        if($validator->fails()) {
            return Response::error($validator->errors()->all());
        }

        $branch  = HospitalBranch::with(['departments' => function($department) {
            $department->with(['department']);
        }])->find($request->branch);
        if(!$branch) return Response::error(['Branch Not Found'],404);

        return Response::success(['Data fetch successfully'],['branch' => $branch],200);
    }
    /**
     * Method for show all days 
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function getScheduleDays(){

        $weeks       = Week::get();
        return view('admin.components.doctor-care.schedule-item',compact('weeks'));
    }
    /**
     * Method for store doctor
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'branch'           => 'required',
            'department'       => 'required',
            'name'             => 'required|string|max:50',
            'doctor_title'     => 'nullable|string',
            'qualification'    => 'required|string|max:100',
            'speciality'       => 'nullable',
            'language'         => 'nullable|array',
            'language.*'       => 'required|string',
            'designation'      => 'required',
            'contact'          => 'required',
            'floor_number'     => 'nullable',
            'room_number'      => 'nullable',
            'address'          => 'nullable',
            'fees'             => 'required|numeric',
            'off_days'         => 'required|string',
            'schedule_day'     => 'required|array',
            'schedule_day.*'   => 'required|string',
            'from_time'        => 'required|array',
            'from_time.*'      => 'required|string',
            'to_time'          => 'required|array',
            'to_time.*'        => 'required|string',
            'max_patient'      => 'required|array',
            'max_patient.*'    => 'required|integer',
            'image'            => 'nullable',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        $validated                              = $validator->validate();
        $validated['slug']                      = Str::uuid();
        $validated['hospital_branch_id']        = $validated['branch'];
        $validated['hospital_department_id']    = $validated['department'];

        if(Doctor::where('hospital_branch_id',$validated['hospital_branch_id'])->where('hospital_department_id',$validated['hospital_department_id'])->where('contact',$validated['contact'])->exists()){
            throw ValidationException::withMessages([
                'name'  => "Doctor already exists!",
            ]);
        }

        $validated['language']    = implode(",",$validated['language']);
        if($request->hasFile("image")){
            $validated['image'] = $this->imageValidate($request,"image",null);
        }

        $shedule_days   = $validated['schedule_day'];
        $from_time      = $validated['from_time'];
        $to_time        = $validated['to_time'];
        $max_patient    = $validated['max_patient'];
        $validated      = Arr::except($validated,['schedule_day','from_time','to_time','max_patient','branch','department']);
        // dd($validated);
        try{
            $doctor = Doctor::create($validated);
            if(count($shedule_days) > 0){
                $days_shedule = [];
                foreach($shedule_days as $key => $day_id){
                    $days_shedule[] = [
                        'doctor_id'   => $doctor->id,
                        'week_id'     => $day_id,
                        'from_time'   => $from_time[$key],
                        'to_time'     => $to_time[$key],
                        'max_patient' => $max_patient[$key],
                        'created_at'  => now(),
                    ];
                }
                DoctorHasSchedule::insert($days_shedule);
            }

        }catch(Exception $e){
            return back()->with(['error' => ["Something went wrong.Please try again."]]);
        }
        return redirect()->route('admin.doctor.care.index')->with(['success' => ["Doctor Created Successfully!"]]);
    }
    /**
     * Method for update doctor status
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function statusUpdate(Request $request){

        $validator = Validator::make($request->all(),[
            'data_target'  => 'required|numeric|exists:doctors,id',
            'status'       => 'required|boolean',
        ]);

        if($validator->fails()){
            $errors = ['error' => $validator->errors() ];
            return Response::error($errors);
        }

        $validated = $validator->validate();
        $doctors = Doctor::find($validated['data_target']);

        try {
            $doctors->update([
                'status'   => ($validated['status']) ? false: true,
            ]);
        } catch (Exception $e) {
            $errors = ['error' => ['Something went wrong! Please try again.'] ];
            return Response::error($errors,null,500);
        }
        $success = ['success' => ['Doctor status updated successfully!']];
        return Response::success($success);
    }
    /**
     * Method for show doctor edit page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function edit($id){
        $page_title          = "Doctor Edit";
        $doctors             = Doctor::find($id);
        if(!$doctors) return back()->with(['error' => ["Doctor Does not exists"]]);

        $hospital_branch     = HospitalBranch::where('status',true)->orderBy('name','ASC')->get();
        $hospital_department = HospitalDepartment::where('status',true)->get();
        $weeks               = Week::get();
        $doctor_has_schedule = DoctorHasSchedule::where('doctor_id',$id)->get();

        return view('admin.sections.doctor-care.edit',compact(
            'page_title',
            'doctors',
            'hospital_branch',
            'hospital_department',
            'weeks',
            'doctor_has_schedule'
        ));
    }
    /**
     * Method for update doctor 
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function update(Request $request,$id){

        $doctor    = Doctor::find($id);
        $validator = Validator::make($request->all(),[
            'branch'            => 'required',
            'department'        => 'required',
            'name'              => 'required|string',
            'doctor_title'      => 'nullable|string',
            'qualification'     => 'required|string',
            'speciality'        => 'nullable',
            'language'          => 'nullable|array',
            'language.*'        => 'nullable|string',
            'designation'       => 'required',
            'contact'           => 'required',
            'floor_number'      => 'nullable',
            'room_number'       => 'nullable',
            'address'           => 'nullable',
            'fees'              => 'required|numeric',
            'off_days'          => 'required|string',
            'schedule_day'      => 'required|array',
            'schedule_day.*'    => 'required|string',
            'from_time'         => 'required|array',
            'from_time.*'       => 'required|string',
            'to_time'           => 'required|array',
            'to_time.*'         => 'required|string',
            'max_patient'       => 'required|array',
            'max_patient.*'     => 'required|integer',
            'image'             => 'nullable'
        ]);
      
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $validated                            = $validator->validate();
        $validated['slug']                    = Str::uuid();
        $validated['hospital_branch_id']      = $validated['branch'];
        $validated['hospital_department_id']  = $validated['department'];
        
        if(Doctor::whereNot('id',$doctor->id)->where('hospital_branch_id',$validated['hospital_branch_id'])->where('hospital_department_id',$validated['hospital_department_id'])->where('contact',$validated['contact'])->exists()){
            throw ValidationException::withMessages([
                'name' => "Doctor already exists!",
            ]);
        }
        $validated['language'] = implode(',',$validated['language']);
        if($request->hasFile('image')){
            $validated['image']  =  $this->imageValidate($request,"image",null);
        }
        $schedule_days     = $validated['schedule_day'];
        $from_time         = $validated['from_time'];
        $to_time           = $validated['to_time'];
        $max_patient       = $validated['max_patient'];
        $validated         = Arr::except($validated,['schedule_day','from_time','to_time','max_patient','branch','department']);
        try{
            $doctor_schedule_ids = $doctor->schedules->pluck('id');
            DoctorHasSchedule::whereIn('id',$doctor_schedule_ids)->delete();

            $doctor->update($validated);
            if(count($schedule_days) > 0){
                $days_schedule = [];
                foreach($schedule_days as $key => $day_id){
                    $days_schedule[]  = [
                        'doctor_id'   => $doctor->id,
                        'week_id'     => $day_id,
                        'from_time'   => $from_time[$key],
                        'to_time'     => $to_time[$key],
                        'max_patient' => $max_patient[$key],
                        'created_at'  => now(),
                    ];
                }
                DoctorHasSchedule::insert($days_schedule);
            }

        }catch(Exception $e){
            return back()->with(['error'  => ['Something went wrong! Please try again.']]);
        }
        return redirect()->route('admin.doctor.care.index')->with(['success' => ['Doctor Updated Successfully!']]);
    }
    /**
     * Method for delete doctor
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function delete(request $request){
        $request->validate([
            'target'    => 'required|numeric',
        ]);

        $doctors = Doctor::find($request->target);

        try {
            $doctors->delete();
        } catch (Exception $e) {
            return back()->with(['error'  =>  ["Something went wrong! Please try again."]]);
        }
        return back()->with(['success'  => ["Doctor Deleted Successfully!"]]);
    }
    /**
     * Method for image validate
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function imageValidate($request,$input_name,$old_image = null) {
        if($request->hasFile($input_name)) {
            $image_validated = Validator::make($request->only($input_name),[
                $input_name         => "image|mimes:png,jpg,webp,jpeg,svg",
            ])->validate();

            $image = get_files_from_fileholder($request,$input_name);
            $upload = upload_files_from_path_dynamic($image,'site-section',$old_image);
            return $upload;
        }
        return false;
    }
}
