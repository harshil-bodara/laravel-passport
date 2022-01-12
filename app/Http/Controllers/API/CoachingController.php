<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Coaching;
use App\Models\User;
use App\Models\Fee;
use App\Http\Controllers\Controller;

class CoachingController extends Controller
{
    public function index(Request $request) {            
    \DB::enableQueryLog();
    if ($request->type == 'online')         {$type_online = 1;}
    if ($request->type == 'offline')        {$type_offline = 1;}
    if ($request->type == 'inhouse')        {$type_inhouse = 1;}  
    if ($request->category_id)              {$category_id = $request->category_id;} else {$category_id = 0; }    
    if ($request->tag_name)                 {$tag_name = $request->tag_name;} else {$tag_name = 0; }
    if ($request->language)                 {$lang = $request->language;} else {$lang = 0; }
    if ($request->avail == 'morning')       {$morning = 1;}
    if ($request->avail == 'afternoon')     {$afternoon = 1;}
    if ($request->avail == 'evening')       {$evening = 1;}
    $limit = 10000;
    $var = (object)[];
    $var->lower = 0; 
    $var->upper =10000;
    if ($request->fee == 'free')            {$var->lower = 0; $var->upper =0; }
    if ($request->fee == 'zero_fifty')      {$var->lower = 1; $var->upper =50; }
    if ($request->fee == 'fifty_hundred')   {$var->lower = 51; $var->upper =100; }
    if ($request->fee == 'hundred_plus')    {$var->lower = 101; $var->upper =10000; }
    //return $var;

     $results = Coaching::select('coachings.*', 'users.first_name', 'users.last_name')   
        ->where('c_is_active', 1)   
        
        ->with(['fees'])->whereHas('fees', function() {})
        ->with(['tags'])->whereHas('tags', function() {})
        
        ->join('users','users.id','=','user_id')
        
        ->when($limit, function($query) use($var) {
            $query->whereHas('fees', function ($q) use($var) { $q->whereBetween('fee_price', [$var->lower, $var->upper]); });
        })        
        ->when($lang, function ($query, $lang) { return $query->where(function($q) use($lang) {
                $q->where('c_language_primary', $lang);
                $q->orWhere('c_language_secondary', $lang);
            });                    
        })        
        ->when(isset($morning), function ($query, $morning) {return $query->where('c_avail_morning', $morning);})
        ->when(isset($afternoon), function ($query, $afternoon) {return $query->where('c_avail_afternoon', $afternoon);})
        ->when(isset($evening), function ($query, $evening) {return $query->where('c_avail_evening', $evening);})        
        ->when(isset($type_online), function ($query, $type_online) {return $query->where('c_type_online', $type_online);})
        ->when(isset($type_offline), function ($query, $type_offline) {return $query->where('c_type_offline', $type_offline);})
        ->when(isset($type_inhouse), function ($query, $type_inhouse) {return $query->where('c_type_inhouse', $type_inhouse);})        
        ->when($category_id, function($query) use($category_id) {
            $query->whereHas('tags', function ($q) use ($category_id) {
                $q->where('category_id', $category_id); });
        })        
        ->when($tag_name, function($query) use($tag_name) {
            $query->whereHas('tags', function ($q) use ($tag_name) {
                $q->where('tag_name', $tag_name); });
        })
        ->get();        
        //dd(\DB::getQueryLog());      
        $results = $results->makeHidden(['c_is_active','c_time_zone', 'c_country','c_phone','c_country_code','c_city','c_banner_img','c_quotation','c_quotation_from','c_description_1','c_description_2','c_description_3','tag_description']);  
        return $results;
    }





    // Show the form for creating a new resource.
    public function create()
    {
        //
    }


    public function store(Request $request) {
        // Check if user_id exists
        if ($request->user_id == NULL) { return response('user_id is missing', 400); }

        // Check if user exists
        if ($coach = User::select('*')->where('id', $request->user_id)->first() ) {
            // Create Coaching
            $coach = Coaching::create($request->all());          
            $coach->save();
            return response($coach, 200);
        } else {
            return response('user_id '.$request->user_id.' not found', 400);
        }    
    }

    public function show($id) {
        $coach = Coaching::select('coachings.*','users.first_name','users.last_name','users.username','users.birthday','users.occupation')        
        ->where('users.username', $id)
        ->join('users','users.id','=','user_id')        
        //->toSql();
        ->first();
        //return $id;
        return $coach;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}