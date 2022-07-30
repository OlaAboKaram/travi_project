<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Governement;
use App\Models\Activity;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
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

        $trip->save();

        return  $trip;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show_recommended_trips()
    {
        $user = auth()->user();
        $trip = Trip::all();
        $triparray = array();
        $userActivities = $user->activities()->get();
        foreach ($userActivities as $useractivity) {
            foreach ($trip as $tripActivity) {
                foreach ($tripActivity->activities()->get() as $tripac) {
                    if ($useractivity->pivot->activity_id == $tripac->pivot->activity_id) {
                        $newTrip_id = $tripac->pivot->trip_id;
                        $triparray[] = $thisTrip = Trip::find($newTrip_id);
                    };
                }
            }
        }
        return $triparray;
    }
    public function likeTrip($id)
    {
        $trip = Trip::find($id);
        $user = auth()->user();
        $trip->like($user);
        $trip->liked($user);
        $trip->save();
        return $trip->likeCount;
    }

    public function dislikeTrip($id)
    {
        $trip = Trip::find($id);
        $user = auth()->user();
        $trip->like($user);
        $trip->liked($user);
        $trip->save();
        return $trip->likeCount;
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
        $trips = Trip::all();
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
                    if ($useractivity->pivot->activity_id == $tripac->pivot->activity_id) {
                        $newTrip_id = $tripac->pivot->trip_id;
                        $thisTrip = Trip::find($newTrip_id);
                    }
                }
            }
        }

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
        $result[] = $thisTrip;
        return $result;
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
        $trips = Trip::all();
        foreach ($trips as $trip) {
            if ($trip->offer == 0)
                $offerdTrips[] = $trip;
        }
        return $offerdTrips;
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
