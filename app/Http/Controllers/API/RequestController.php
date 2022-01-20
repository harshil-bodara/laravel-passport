<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CoachingRequest;
use App\Models\Coaching;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller {

    public function index() {
        $coaching_requests = CoachingRequest::select('*')
        ->get();
        return response($coaching_requests, 200);
    }


    public function store( Request $request ) {

        $validator = Validator::make($request->all(), [
            'coaching_id' => 'required|int',
            'user_id' => 'required|int',
            'r_status' => 'required|string',
        ]);     
        
        
        
        if ($validator->fails()) { return response(['errors'=>$validator->errors()->all()], 422); }
        if(Coaching::find($request->coaching_id) == null) { 
            $response = ["message" => "coaching_id not found",'request' => $request->all(),];
            return response($response, 406);
        }

        if(User::find($request->user_id) == null) { 
            $response = ["message" => "user_id not found",'request' => $request->all(),];
            return response($response, 406);
        }

        $coaching_request = CoachingRequest::create($request->toArray());  
        
        $response = [
            "message" => "Coaching Request Created",
            'request' => $coaching_request,            
        ];
        return response($response, 200);
    }

    
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        //
    }















    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //    
    }

    


    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        //
    }
}
