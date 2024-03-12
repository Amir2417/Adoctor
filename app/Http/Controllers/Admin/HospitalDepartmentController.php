<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\HospitalDepartment;


class HospitalDepartmentController extends Controller
{
    public function index(){
        $page_title           = "Hospital Departments";
        $hospital_departments = HospitalDepartment::orderByDesc("id")->paginate(11);

        return view('admin.sections.hospital-department.index',compact(
            'page_title',
            'hospital_departments'
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string|max:80|unique:hospital_departments,name',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","add-hospital-departments");
        }

        $validated = $validator->validate();
        // dd($request->all());

        $slug  = Str::slug($request->name);

        $validated['slug']              = $slug;
        $validated['status']            = 1;
        $validated['last_edit_by']      = auth()->user()->id;
        // dd($validated);
        try{
            HospitalDepartment::create($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return back()->with(['success' => ['Hospital Department created successfully!']]);

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'target'        => 'required|numeric|exists:hospital_departments,id',
            'edit_name'     => 'required|string|max:80|',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","hospital-departments-edit");
        }

        $validated = $validator->validate();
        
        $slug      = Str::slug($request->edit_name);
        $validated = replace_array_key($validated,"edit_");
        $validated = Arr::except($validated,['target']);
        $validated['slug']   = $slug;
        $validated['last_edit_by']   = auth()->user()->id;
        $hospital_departments = HospitalDepartment::find($request->target);
        
        try{
            $hospital_departments->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['Hospital Department updated successfully!']]);
        
    }
    public function delete(Request $request){
       $request->validate([
        'target'    => 'required|numeric|',
       ]);
       $hospital_departments = HospitalDepartment::find($request->target);

       try {
            $hospital_departments->delete();
       } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
       }
       return back()->with(['success' => ['Hospital Department Deleted Successfully!']]);

    }

    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'       => 'required|numeric|exists:hospital_departments,id',
            'status'            => 'required|boolean',
        ]);

        if($validator->fails()) {
            $errors = ['error' => $validator->errors() ];
            return Response::error($errors);
        }

        $validated = $validator->validate();


        $hospital_departments = HospitalDepartment::find($validated['data_target']);

        try{
            $hospital_departments->update([
                'status'        => ($validated['status']) ? false : true,
            ]);
        }catch(Exception $e) {
            $errors = ['error' => ['Something went wrong! Please try again.'] ];
            return Response::error($errors,null,500);
        }

        $success = ['success' => [__('Hospital Department status updated successfully!')]];
        return Response::success($success);
    }
}
