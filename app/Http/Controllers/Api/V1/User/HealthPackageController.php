<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\HealthPackage;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class HealthPackageController extends Controller
{
    public function healthPackage(){
        $health_packages = HealthPackage::where("status",true)->orderBy("id")->get()->map(function($data){
            return [
                'id'              => $data->id,
                'name'            => $data->name,
                'slug'            => $data->slug,
                'title'           => $data->title,
                'price'           => $data->price,
                'offer_price'     => $data->offer_price,
                'status'          => $data->status,
                'last_edit_by'    => $data->last_edit_by,
                'created_at'      => $data->created_at,   
            ];

        });
        
        return Response::success(['Health Package Data Fetch Successfully.'],[
            'health_package'  => $health_packages,
        ],200);
    }

    //health package search

    public function healthPackageSearch(Request $request){

        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return Response::error($validator->errors()->all(),[]);
        }

        $health_package   = HealthPackage::where('name','like','%'. $request->name .'%')->get();
        if($health_package->isEmpty()){
            return Response::error(['Health Package not found!'],[],400);
        }
        return Response::success(['Health Package find successfully'],$health_package,200);
        

    }
}
