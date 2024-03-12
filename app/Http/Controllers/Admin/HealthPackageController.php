<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\Investigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\HealthPackage;
use App\Models\Admin\PackageHasTest;


class HealthPackageController extends Controller
{
    public function index(){
        $page_title             = "Health Packages";
        $health_packages = HealthPackage::orderByDesc('id')->paginate(10);

        return view('admin.sections.health-package.index',compact(
            'page_title',
            'health_packages',
        ));
    }
    public function create(){
        $page_title = "Health Package Create";
        $hospital_tests = Investigation::where('status', true)->get();

        return view('admin.sections.health-package.create',compact(
            'page_title',
            'hospital_tests',
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'              => 'required|string|max:80|',
            'title'             => 'nullable',
            'price'             => 'required|numeric',
            'offer_price'       => 'nullable',
            
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput()->with('modal','add-health-package');
        }

        $validated = $validator->validate();

        $slug                           = Str::slug($request->name);
        $validated['slug']              = $slug;
        $validated['status']            = true;
        $validated['last_edit_by']      = auth()->user()->id;
        
        // dd($validated);
        try{
            HealthPackage::create($validated);
            
            
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return redirect()->route('admin.health.package.index')->with(['success' => ['Hospital Package created successfully!']]);   
    }

    public function edit($slug){
        $page_title  = "Health Package Edit";
        $package     = HealthPackage::where('slug',$slug)->first();
        if(!$package) return back()->with(['error' => ['Package not found!']]);
        $hospital_tests = Investigation::where('status',true)->get();

        return view('admin.sections.health-package.edit',compact(
            'page_title',
            'package',
            'hospital_tests',
        ));
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'target'           => 'required|numeric|exists:health_packages,id',
            'edit_name'        => 'required|string|max:100',
            'edit_title'       => 'nullable|string',
            'edit_price'       => 'required|numeric',
            'edit_offer_price' => 'nullable',
            
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","health-package-edit");
        }
        

        $validated = $validator->validate();
        
        $slug      = Str::slug($request->edit_name);
        $validated = replace_array_key($validated,"edit_");
        $validated = Arr::except($validated,['target']);
        $validated['slug'] = $slug;
        $validated['last_edit_by'] = auth()->user()->id;
        $hospital_test = HealthPackage::find($request->target);

        try{
            $hospital_test->update($validated);
        }catch(Exception $e){
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' => ['Health Package updated successfully!']]);
    }
    public function delete(Request $request){
        $request->validate([
            'target'    => 'required|numeric|',
        ]);
        $package = HealthPackage::find($request->target);

        try {
            $package->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' => ['Hospital Package Deleted Successfully!']]);
    }
    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'       => 'required|numeric|exists:health_packages,id',
            'status'            => 'required|boolean',
        ]);

        if($validator->fails()) {
            $errors = ['error' => $validator->errors() ];
            return Response::error($errors);
        }

        $validated = $validator->validate();


        $hospital_departments = HealthPackage::find($validated['data_target']);

        try{
            $hospital_departments->update([
                'status'        => ($validated['status']) ? false : true,
            ]);
        }catch(Exception $e) {
            $errors = ['error' => ['Something went wrong! Please try again.'] ];
            return Response::error($errors,null,500);
        }

        $success = ['success' => [__('Hospital Package status updated successfully!')]];
        return Response::success($success);
    }
}
