<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Admin\Investigation;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    public function investigation(){
        $investigations = Investigation::where("status",true)->orderBy("id")->get()->map(function($data){
            return [
                'id'            => $data->id,
                'name'          => $data->name,
                'slug'          => $data->slug,
                'price'         => $data->price,
                'offer_price'   => $data->offer_price,
                'status'        => $data->status,
                'home_service'  => $data->home_service,
                'last_edit_by'  => $data->last_edit_by,
                'created_at'    => $data->created_at,
            ];
        });
        return Response::success(["Investigation Data Fetch Successfully."],
        [
            'isvestigation'    => $investigations,
        ],200);
    }
    //investigation Search
    public function investigationSearch(Request $request){
        
        $validator  = Validator::make($request->all(),[
            'investigation'  => 'required',
        ]);

        if($validator->fails()) return Response::error($validator->errors()->all(),[]);

        $investigation             = Investigation::where('name','like','%'.$request->investigation.'%')->get();

        if($investigation->isEmpty()) {
            return Response::error(['Investigation not found!'],[],404);
        }

        return Response::success(['Investigation find successfully.'],$investigation,200);
        
    }
}
