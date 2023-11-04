<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\HospitalBranch;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function branch(){
        $branches  = HospitalBranch::where("status",true)->orderBy("id")->get()->map(function($data){
            return [
                'id'           => $data->id,
                'name'         => $data->name,
                'email'        => $data->email,
                'web'          => $data->web,
                'description'  => $data->description,
                'slug'         => $data->slug,
                'status'       => $data->status,
                'last_edit_by' => $data->last_edit_by,
                'created_at'   => $data->created_at,
            ];
        });

        return Response::success(['Branch Data fetch Successfully.'],$branches,200);
    }

    // branch search
    public function branchSearch(Request $request){
        $validator = Validator::make($request->all(),[
            'name'  => 'required'
        ]);

        if($validator->fails()){
            return Response::error($validator->errors()->all(),[]);
        }

        $branch      = HospitalBranch::where('name','like','%'.$request->name.'%')->get();

        if($branch->isEmpty()){
            return Response::error(['Branch not found!'],[],400);
        }
        
        return Response::success(['Branch find Successfully.'],$branch,200);
    }
}
