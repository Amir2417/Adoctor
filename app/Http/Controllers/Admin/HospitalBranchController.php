<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Admin\BranchHasDepartment;
use App\Models\Admin\HospitalBranch;
use App\Models\Admin\HospitalDepartment;
use Illuminate\Http\Request;

class HospitalBranchController extends Controller
{
    public function index(){
        $page_title           = "Hospital Branch";
        $hospital_branch = HospitalBranch::orderByDesc("id")->get();

        return view('admin.sections.hospital-branch.index',compact(
            'page_title',
            'hospital_branch'
        ));
    }
    public function create(){
        $page_title               = "Hospital Branch Create";
        $hospital_departments     = HospitalDepartment::where('status',true)->get();

        return view('admin.sections.hospital-branch.create',compact(
            'page_title',
            'hospital_departments'
        ));
    }
    public function store(Request $request){


        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'              => 'required|string|max:80|unique:hospital_branches,name',
            'email'             => 'required|string',
            'web'               => 'required|url',
            'description'       => 'required|string|max:2555',
            'departments'       => 'required|array',
            'departments.*'     => 'required|integer',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $validated = $validator->validate();
        // dd($request->all());

        $slug  = Str::slug($request->name);

        $validated['slug']              = $slug;
        $validated['status']            = 1;
        $validated['last_edit_by']      = auth()->user()->id;
        // dd($validated);
        try{
            $branch = HospitalBranch::create($validated);
            // dd($branch->id);
            if(count($validated['departments']) > 0) {
                $departments = [];
                foreach($validated['departments'] as $department_id) {
                    $departments[] = [
                        'hospital_branch_id'      => $branch->id,
                        'hospital_department_id'  => $department_id,
                        'created_at'              => now(),
                    ];
                }
                BranchHasDepartment::insert($departments);
            }
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return redirect()->route('admin.hospital.branch.index')->with(['success' => ['Hospital Branch created successfully!']]);

    }
    public function edit($id){

        $branch = HospitalBranch::find($id);

        $hospital_departments     = HospitalDepartment::where('status',true)->get();
        if(!$branch) return back()->with(['error'=> ['Branch Not Found']]);
        $page_title  = "Hospital Branch Edit";

        return view('admin.sections.hospital-branch.edit',compact(
            'branch',
            'hospital_departments',
            'page_title'
        ));

    }
    public function update(Request $request,$id)
    {
        
        $branch     = HospitalBranch::find($id);
        
        $validator = Validator::make($request->all(),[
            'name'              => 'required|string|max:80',
            'email'             => 'required|string',
            'web'               => 'required|url',
            'description'       => 'required|string|max:2555',
            'departments'       => 'required|array',
            'departments.*'     => 'required|integer',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated           = $validator->validate();
        $request_departments = $validated['departments'];
        $validated           = Arr::except($validated,['departments']);

        $slug                        = Str::slug($validated['name']);
        $validated['slug']           = $slug;
        $validated['last_edit_by']   = auth()->user()->id;

        try{

            $branch_department_ids = $branch->departments->pluck('id');
            // dd($branch_department_ids);
            BranchHasDepartment::whereIn('id',$branch_department_ids)->delete();

            $branch->update($validated);
            if(count($request_departments) > 0) {
                
                $departments = [];
                foreach($request_departments as $department_id) {
                    $departments[] = [
                        'hospital_branch_id'      => $branch->id,
                        'hospital_department_id'  => $department_id,
                        'created_at'              => now(),
                    ];
                }
                BranchHasDepartment::insert($departments);
            }
            
           
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return redirect()->route('admin.hospital.branch.index')->with(['success' => ['Hospital Branch updated successfully!']]);
        
    }
    public function delete(Request $request){
       $request->validate([
        'target'    => 'required|numeric|',
       ]);
       $hospital_branch = HospitalBranch::find($request->target);

       try {
            $hospital_branch->delete();
       } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
       }
       return back()->with(['success' => ['Hospital Branch Deleted Successfully!']]);

    }

    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'       => 'required|numeric|exists:hospital_branches,id',
            'status'            => 'required|boolean',
        ]);

        if($validator->fails()) {
            $errors = ['error' => $validator->errors() ];
            return Response::error($errors);
        }

        $validated = $validator->validate();


        $hospital_departments = HospitalBranch::find($validated['data_target']);

        try{
            $hospital_departments->update([
                'status'        => ($validated['status']) ? false : true,
            ]);
        }catch(Exception $e) {
            $errors = ['error' => ['Something went wrong! Please try again.'] ];
            return Response::error($errors,null,500);
        }

        $success = ['success' => [__('Hospital Branch status updated successfully!')]];
        return Response::success($success);
    }
}
