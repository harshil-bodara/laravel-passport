<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coaching;

class CoachCountryController extends Controller {

    public function index( Request $request ) {

        if ( $request->country_code && $request->city ) {

            $city = str_replace( '-', ' ', $request->city );
            return $results = Coaching::select( 'coachings.id', 'c_title', 'c_country', 'c_country_code', 'c_city', 'users.first_name', 'users.last_name' )
            ->where( 'c_is_active', 1 )
            ->where( 'c_country_code', $request->country_code )
            ->where( 'c_city', $city )
            ->join( 'users', 'users.id', '=', 'user_id' )
            ->get();

        } elseif ( $request->country_code ) {

            return $results = Coaching::select( 'c_country', 'c_country_code', 'c_city', Coaching::raw( 'count(*) as total' ) )
            ->groupBy( 'c_country', 'c_country_code', 'c_city' )
            ->where( 'c_is_active', 1 )
            ->where( 'c_country_code', $request->country_code )
            ->join( 'users', 'users.id', '=', 'user_id' )
            ->get();

        } else {
            
            return $results = Coaching::select( 'c_country', 'c_country_code', Coaching::raw( 'count(*) as total' ) )
            ->where( 'c_is_active', 1 )
            ->groupBy( 'c_country', 'c_country_code' )
            ->get( array( 'c_country' ) );
        }
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
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {

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
