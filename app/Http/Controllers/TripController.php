<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Governement;
use App\Models\Activity;
use Illuminate\Validation\ValidationException;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use dnsimmons\openweather\OpenWeather;
use RakibDevs\Weather\Weather;

use App\Models\Rating;
use willvincent\Rateable\Rating as RateableRating;

class TripController extends Controller
{
    use Rateable;
    /**
     * 
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

        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'age' => 'required|string|max:50',
                'type' => 'required|string|max:50',
                'start_date' => 'required|date',
                'expiry_date' => 'required|date',
                'start_trip' => 'required|date',
                'start_date' => 'required|date',
                'end_trip' => 'required|date',
                'total' => 'required|integer',
                'start_date' => 'required|date',
                'image' => 'required|image',
                'coutinent' => 'required|string',
                'reiteration' => 'required|integer',
                'name_team' => 'required|string',
                'about' => 'required|string|max:255|min:120',
                'offer' => 'required|integer'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        //   $imageName = time().'.'.$request->image->getClientOriginalExtension();
        //   $request->image->move(public_path('images'), $imageName);

        $trip = new Trip;
        $trip->name = $request->name;
        $trip->age = $request->age;
        $trip->type = $request->type;
        $trip->price = $request->price;
        $trip->start_date = $request->start_date;
        $trip->expiry_date = $request->expiry_date;
        $trip->start_trip = $request->start_trip;
        $trip->end_trip = $request->end_trip;
        $trip->total = $request->total;
        $trip->image = $request->image;
        $trip->coutinent = $request->coutinent;
        $trip->reiteration = $request->reiteration;
        $trip->name_team = $request->name_team;
        $trip->about = $request->about;
        $trip->offer = $request->offer;
        $trip->image = $request->image->hashName();
        $trip->rest = $trip->total;
        //image//
        $file = $request->file('image');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename);
        $trip['image'] = $filename;
        //
        $trip->save();
        return response()->json(['message' => 'admin successfully added trip', 'trip' => $trip]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */

    public function show_trip_details($id)
    {
        $trip = Trip::find($id);
        $likes = $trip->likeCount;
        $result[] = $trip;
        $tripAreas = $trip->areas;
        foreach ($tripAreas as $tripArea) {
            $arealike[] = $tripArea->likeCount;
        }


        return response()->json([$result]);
    }



    public function addRate(Request $request, $id)
    {
        $trip = Trip::findorfail($id);
        $rating = new RateableRating();
        $rating->comment = $request->input('comment');
        $rating->rating = $request->input('star');
        $rating->user_id = auth()->user()->id;
        // Add a rating of 5, from the currently authenticated user
        $trip->ratings()->save($rating);
        echo $trip;
    }


    public function home()
    {
        $user = auth()->user();
        $trips = Trip::where('start_date', '>', today())->get();
        $triparray = array();
        foreach ($trips as $trip) {
            if ($trip->offer != 0)
                $offerdTrips = $trip;
        }
        $result[] = $user;
        $result[] = $offerdTrips;
        $userActivities = $user->activities()->get();
        foreach ($userActivities as $useractivity) {
            foreach ($trips as $tripActivity) {
                foreach ($tripActivity->activities()->get() as $tripac) {
                    if ($useractivity->pivot->activity_id = $tripac->pivot->activity_id) {
                        $newTrip_id = $tripac->pivot->trip_id;
                        $triparray = $thisTrip = Trip::find($newTrip_id);
                    }
                }
            }
        }

        // $result[] = $thisTrip;
        foreach ($trips as $rateTrip) {
            $rateResult[] = $rateTrip->getAverageRatingAttribute();
        }
        $maxrate = max($rateResult);
        foreach ($trips as $rateTrip) {
            if ($rateTrip->getAverageRatingAttribute() == $maxrate) {
                $highRated = $rateTrip;
            }
        }
        $result[] = $highRated;
        return response()->json(['user' => $user, '$offerdTrips' => $offerdTrips, 'recommended' => $triparray, 'best trip' => $highRated], 200);
    }

    public function delete_trip($id)
    {
        $trip = Trip::find($id);
        if (!$trip) {
            return response()->json(['error' => 'not found'], 404);
        }
        $result = $trip->delete();
        if ($result) {
            return response()->json(['error' => 'not found'], 200);
        }
    }

    public function show_offered_trips()
    {
        $user = auth()->user();
        $trips = Trip::where('start_date', '>', today())->get();
        $trips = Trip::paginate(3);
        foreach ($trips as $trip) {
            if ($trip->offer != 0)
                $offerdTrips[] = $trip;
        }
        return $offerdTrips;
    }

    //////////////////////////////////////////
    public function showTrip(Request $request)
    {
        $trip = Trip::where('start_trip', '>', today())->orderBY('start_trip', 'asc')->get();
        return $trip;
    }
    public function listAlltrip(Request $request)
    {
        if ($request->sortby) {
            $sortby = $request->sortby;
            $trip = Trip::where('start_trip', '>', today())->orderBY($sortby, 'desc')->withCount('activities', 'daily_program')->get();

            return $this->responseData($trip, 'successfully fetched');
        }
        $trip  = Trip::latest()->where('start_trip', '>', today())->withCount('activities', 'daily_program')->get(); //,'comment','like'
        $trip_invalid = Trip::where('start_trip', '<', today());
        $trip_invalid->delete();
        return $this->responseData($trip, 'successfully fetched');
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
        $trip = Trip::where("name", "like", "%" . $name . "%")->where('start_trip', '>', today())->Orderby('start_trip', 'asc')->get();
        // $sortby=$trip->sortby;
        // $trip1=Trip::Orderby($sortby,'desc');
        //return $this->responseData($trip,'successfully');
        //return response()->json(['message' => 'User successfully select state']);
        return $trip;
    }

    public function search_price($price)
    {
        $trip = Trip::where("price", $price)->round($price, 2)->where('start_trip', '>', today())->Orderby('start_trip', 'asc')->get();
        return $trip;
    }
    public function search_name_team($name_team)
    {
        $trip = Trip::where("name_team", "like", "%" . $name_team . "%")->where('start_trip', '>', today())->Orderby('start_trip', 'asc')->get();
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
        $trip = Trip::where("name", "like", "%" . $request . "%")
            ->orwhere("name_team", "like", "%" . $request . "%")
            ->orwhere("price", "like", "%" . $request)
            ->orwhere("type", "like", "%" . $request . "%")
            ->orwhere("age", "like", "%" . $request . "%")
            ->orwhere("coutinent", "like", "%" . $request . "%")
            ->where('start_trip', '>', today())
            ->Orderby('start_trip', 'asc')
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
        if ($trip->isEmpty()) {
            return ["result" => " trip not trip not delete "];
        }
        return $trip;
    }


    public function register($trip_id)
    {
        $trip = Trip::find($trip_id);
        $user = auth()->user();


        if ($trip->rest == 0) {
            return ["result" => " Can't be recorded because the number is complete"];
        }

        $trip->rest--;
        $trip->update();
        // $user = user::find($user_id);
        $trip->users()->attach($user->id);
        // $user->trips()->attach($trip_id);
        //  if(!$trip|!$user)
        //  {
        //   return ["result"=>" not find"];
        //  }
        return ["result" => "correct registration"];
    }
    public function registerTrip($trip_id)
    {
        $trip = Trip::find($trip_id);
        return $trip->users;
    }
    public function registerUser()
    {
        $user = auth()->user();
        return $user->trips;
    }

    public function weather()
    {
        $wt = new Weather();
        $info = $wt->getCurrentByZip('94040,us');
    }
    //  public function registerRest($trip_id){
    //   $trip = Trip::find($trip_id);
    //   return  $trip->rest ;
    //  }


}
