<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Governement;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use App\Models\Rating;
use willvincent\Rateable\Rating as RateableRating;

class UserTripController extends Controller
{
    use Rateable;
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }


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
        $result['details'] = $trip;
        $result['avg_rate'] = $trip->getAverageRatingAttribute();

        $tripAreas = $trip->areas;
        foreach ($tripAreas as $tripArea) {
            $arealike[] = $tripArea->likeCount;

        }


        return response()->json([$result]);
    }

public function show_Liked_trips(){
    $user=auth()->user()->id;
   return Trip::whereLikedBy($user) // find only posts where user liked them
    ->with('likeCounter') // highly suggested to allow eager load
    ->get();
}

    public function show_recommended_trips()
    {
        $user = auth()->user();
        $trip = Trip::where('start_date', '>', today())->get();
        $triparray = array();
        $userActivities = $user->activities()->get();
        foreach ($userActivities as $useractivity) {
            foreach ($trip as $tripActivity) {
                foreach ($tripActivity->activities()->get() as $tripac) {
                    if ($useractivity->pivot->activity_id = $tripac->pivot->activity_id) {
                        $newTrip_id = $tripac->pivot->trip_id;
                        $triparray[]  = Trip::find($newTrip_id);
                    };
                }
            }
        }
        $tripResult = array_unique($triparray);
        if (!$tripResult) {
            return response()->json(['error' => 'there is no available trips'], 404);
        }
        return $tripResult;
    }
    public function likeTrip($id)
    {
        $trip = Trip::find($id);
        $user = auth()->user()->id;
        $trip->like($user);
        $trip->save();
        return $trip->likeCount;
    }
    public function likesNum($id){
        $trip = Trip::find($id);
        return $trip->likeCount;
    }

    public function dislikeTrip($id)
    {
        $trip = Trip::find($id);
        $user = auth()->user()->id;
        $trip->unlike($user);
        $trip->save();
        return $trip->likeCount;
    }
    public function addRate(Request $request, $id)
    {
        $user = auth()->user();
        $trip = Trip::find($id);

        $userId = auth()->user()->id;
        $userTrips = auth()->user()->trips;
        foreach ($userTrips as $userTrip) {
            if ($userTrip->id = $trip->id) {
                $rating = new RateableRating();
                $rating->comment = $request->input('comment');
                $rating->rating = $request->input('star');
                $rating->user_id = auth()->user()->id;
                // Add a rating of 5, from the currently authenticated user
                $trip->ratings()->save($rating);
            }
        }
        return   $trip->ratings;
        /* $trips = Trip::where('id' , '=', $id)->where('end_trip','<',today());
      //  if ($trips->end_trip > today()){
       //     return response()->json(['error' => 'you can not rate this trip'], 404);
      //  }
    
        
      //  foreach($){
            
        }
        $rating = new RateableRating();
        $rating->comment = $request->input('comment');
        $rating->rating = $request->input('star');
        $rating->user_id = auth()->user()->id;
        // Add a rating of 5, from the currently authenticated user
        $trip->ratings()->save($rating);
        echo $trip;*/
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
        return response()->json(['user' => $user, '$offerdTrips' => $offerdTrips, 'recommended' => $triparray, 'best trip' => $highRated], 404);
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

    public function highrated_trips()
    {
        $trips = Trip::where('start_date', '>', today())->get();
        $trip = Trip::paginate(4);

            $rateResult[] = Trip::withAvg('ratings', 'rating')->orderBy('ratings_avg_rating', 'desc')->take(5)->get();;

        return $rateResult;
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
}
