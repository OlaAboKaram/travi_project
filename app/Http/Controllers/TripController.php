<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Trip;
use App\Models\Governement;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $trip=new Trip;
        $trip->name=$request->name;
        $trip->age=$request->age;
        $trip->type=$request->type;
        $trip->price=$request->price;
        $trip->start_date=$request->start_date;
        $trip->expiry_date=$request->expiry_date;
        $trip->start_trip=$request->start_trip;
        $trip->end_trip=$request->end_trip;
        $trip->total=$request->total;
        $trip->rest =$request->total;
        $trip->image=$request->image;
        $trip->coutinent=$request->coutinent;
        $trip->reiteration=$request->reiteration;
        $trip->name_team=$request->name_team;
        $trip->about=$request->about;
        $trip->save();

        return  $trip;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    
    public function showTrip(Request $request)
    {
        $trip= Trip::where('start_trip','>',today())->orderBY('start_trip','asc')->get();
        return $trip;
    }
    public function listAlltrip(Request $request)
    {
      if($request->sortby)
      {
        $sortby=$request->sortby;
        $trip =Trip::where('start_trip','>',today())->orderBY($sortby,'desc')->withCount('activities','daily_program')->get();

        return $this->responseData($trip,'successfully fetched');
      }
     $trip  =Trip::latest()->where('start_trip','>',today())->withCount('activities','daily_program')->get();//,'comment','like'
     $trip_invalid =Trip::where('start_trip','<',today());
     $trip_invalid->delete();
      return $this->responseData($trip,'successfully fetched');
     // return response()->json(['message' => 'User successfully select state']);
    }


    public function search_name($name)
     {
    //   $validate=Validator::make($request->all(), ['name'=>'required']);
    //   // if($validate->fails())
    //   // {
    //   //   return $this->responseError($validate->errors());
    //   // }
             
    //   $trip =Trip::where('name',$request->name)->first();
    //   // if(!$trip)
    //   // {
    //   //   return $this->responseError('trip not found');
    //   // }
    //   $trip1 =Trip::where('name',$request->name)->get();

    //   return $this->responseData($trip1,'successfully');
    $trip =Trip::where("name","like","%".$name."%")->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
   // $sortby=$trip->sortby;
   // $trip1=Trip::Orderby($sortby,'desc');
    //return $this->responseData($trip,'successfully');
    //return response()->json(['message' => 'User successfully select state']);
    return $trip;
    }
   
    public function search_price($price)
    {
      $trip =Trip::where("price",$price)->round( $price,2)->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
      return $trip;
    }
    public function search_name_team($name_team)
    {
     $trip =Trip::where("name_team","like","%".$name_team."%")->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
      return $trip;
    }/*
    public function search_type($type)
    {
      $trip =Trip::where("type",$type)->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
     
     // return response()->json(['message' => 'User successfully select governement']);
     if(!$trip)
      {
       return response()->json(['message' => 'User successfully select governement']);
     }

     return $trip;
    // return response($trip)->json(['kff']);
      /*
      switch($type){
      case('family'):

      }   
    }*/
    /*
    public function search_age($age)
    {
      $trip =Trip::where("age",$age)->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
    return $trip;
    }
    public function search_coutinent($coutinent)
    {
      $trip =Trip::where("coutinent",$coutinent)->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
    return $trip;
    }*/
   public function search($request)
   {
   // $trip=Trip::where('start_trip','>',today())->Orderby('start_trip','asc')->get();
  //  if(where("age",$request)){
// return $trip;
    //  $trip =Trip::where("age",$request)->where('start_trip','>',today())->Orderby('start_trip','asc')->get() ;
    //    $trip =Trip::where("type",$request)->where('start_trip','>',today())->Orderby('start_trip','asc')->get();
       $trip =Trip::where("name","like","%".$request."%")
       ->orwhere("name_team","like","%".$request."%")
       ->orwhere("price","like","%".$request)
       ->orwhere("type","like","%".$request."%")
        ->orwhere("age","like","%".$request."%")
        ->orwhere("coutinent","like","%".$request."%")
       ->where('start_trip','>',today())
       ->Orderby('start_trip','asc')
       ->get();
      //  $okfj=$trip->id;
      //  if (!$okfj)
      //  {
      //    return ["result"=>" trip not trip not delete "];
      //  }
      // return response()->view('$trip', compact('variableName'));
        // return $trip =Trip::where('start_trip','>',today())->Orderby('start_trip','asc')->get();
       // return $this->responseData($trip,'successfully');
      //  return response()->json(['message' => 'User successfully select state']);
       // return response()->json($trip->getResponse()); 
       if ($trip->isEmpty())
       {
         return ["result"=>" trip not trip not delete "];
       }
       return $trip;
   }



    public function delet_trip($id)
    {
     $trip= Trip::find($id);
     if (!$trip)
     {
       return ["result"=>" trip not trip not delete "];
     }
      $result= $trip->delete();
    if($result)
    {
      return ["result"=>" successfully delete trip"];
    }
    
    // if (!$trip)
    // {
    //   return ["result"=>" trip not delete "];
    // }
    
    //  return response()->json(['message' => 'User successfully select governement']);

    // $data=Trip::where('user_id',$request->user()->id)->get();
     // return $this->responseData($data,'deleted successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        //
    }

    public function register($trip_id,$user_id){
       $trip = Trip::find($trip_id);
       $trip->rest--;
       
       $trip->update();
       $user = user::find($user_id);
       $trip->users()->attach($user_id);
       $user->trips()->attach($trip_id);
   return  $trip->rest ;
    }
    public function registerTrip($trip_id){
      $trip=Trip::find($trip_id);
      return $trip->users;
    }
    public function registerUser($user_id){
      $user=User::find($user_id);
      return $user->trips;
    }
     public function registerRest($trip_id){
      $trip = Trip::find($trip_id);
      return  $trip->rest ;
     }

}
