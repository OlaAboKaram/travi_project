<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Governement;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

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
        $triparray=array();
        $userActivities = $user->activities()->get();
        foreach ($userActivities as $useractivity) {
            foreach ($trip as $tripActivity) {
                foreach ($tripActivity->activities()->get() as $tripac) {
                    if ($useractivity->pivot->activity_id == $tripac->pivot->activity_id) {
                        $newTrip_id = $tripac->pivot->trip_id;
                        $triparray[]= $thisTrip = Trip::find($newTrip_id);
                    };
                }
            }
        }//$triparray->toArray();
        return $triparray;
    }



    public function show_offered_trips()
    {
        $user = auth()->user();
         $trips = Trip::all();
        foreach($trips as $trip){
            if ($trip->offer == 0)
            $offerdTrips[]=$trip;
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
