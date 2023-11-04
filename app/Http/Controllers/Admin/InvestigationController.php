<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\Investigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvestigationController extends Controller
{
    public function index(){
        $page_title     = "Investigations";
        $investigations = Investigation::orderByDesc("id")->paginate(10);

        return view('admin.sections.investigation.index',compact(
            'page_title',
            'investigations'
        ));
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'home_service' => 'nullable|integer',
        ]);
       
        if($validator->fails()) return back()->withErrors($validator->errors())->withInput()->with('modal','add-investigation');

        $validated = $validator->validate();

        $slug      = Str::slug($request->name);
        $validated['slug'] = $slug;
        $validated['status'] = 1;
        $validated['last_edit_by'] = auth()->user()->id;
        // dd($validated);
        try{
            Investigation::create($validated);
        }catch(Exception $e){
            
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' =>['Investigation created Successfully!']]);
    }
    public function statusUpdate(Request $request){
        $validator    = Validator::make($request->all(),[
            'data_target'    => 'required|numeric|exists:investigations,id',
            'status'         => 'required|boolean',
        ]);
        if($validator->fails()){
            $errors = ['error' => $validator->errors() ];
            return Response::error($errors);
        }
        $validated =$validator->validate();

        $hospital_test = Investigation::find($validated['data_target']);
        // dd($hospital_test);
        try{
            $hospital_test->update([
                'status' => ($validated['status']) ? false :true,
            ]);
        }catch(Exception $e){
            return Response::error(['error' => ['Something went wrong! Please try again.']],null,500);
        }
        return Response::success(['success' => ['Investigation status updated successfully!']]);
    }
    
    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'target'           => 'required|numeric|exists:investigations,id',
            'edit_name'        => 'required|string|max:100',
            'edit_price'       => 'required|numeric',
            'edit_offer_price' => 'nullable',
            'edit_home_service'     => 'required|boolean',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","investigation-edit");
        }
        

        $validated = $validator->validate();
        
        $slug      = Str::slug($request->edit_name);
        $validated = replace_array_key($validated,"edit_");
        $validated = Arr::except($validated,['target']);
        $validated['slug'] = $slug;
        $validated['last_edit_by'] = auth()->user()->id;
        $hospital_test = Investigation::find($request->target);

        try{
            $hospital_test->update($validated);
        }catch(Exception $e){
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' => ['Investigation updated successfully!']]);
    }

    public function delete(Request $request){
        $request->validate([
            'target'    => 'required|numeric|',
        ]);
        $hospital_test = Investigation::find($request->target);
    
        try {
            $hospital_test->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        return back()->with(['success' => ['Investigation Deleted Successfully!']]);
    }
}
