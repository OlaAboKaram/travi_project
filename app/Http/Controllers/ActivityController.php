<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;


class ActivityController extends Controller
{
    /**
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

    public function insert_user_activities(Request $request)
    {
        $user = auth()->user();
        $activities = array();
        $activities = $request->input('activities');
        foreach ($activities as $Thisactivity) {
            $activity = Activity::where('name', 'LIKE', '%' . $Thisactivity . '%')->select('id')->get();
            $user->activities()->attach($activity);
        }
        return response()->json([
            'message' => 'User successfully selected activity',
        ], 201);
    }
    public function select_trip_activities(Request $request, $id)
    {
        // $user =auth()->user();
        $trip = Trip::find($id);
        $activities = array();
        $activities = $request->input('activities');
        foreach ($activities as $Thisactivity) {
            $activity = Activity::where('name', 'LIKE', '%' . $Thisactivity . '%')->select('id')->get();
            $trip->activities()->attach($activity);
        }
        return response()->json([
            'message' => 'This activity was added to the trip',
        ], 201);
    }

    public function show_user_activities()
    {
        $user = auth()->user();
        return $user->activities;
    }

    public function show_activities()
    {
        $user = auth()->user();
        $allActivities = Activity::all();
        $validator = validator();
        if ($allActivities->isEmpty()) {
            return response()->json([
                'message' => 'there is no activities',
            ], 201);
        } else {
            return $allActivities;
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activity = new Activity;
        $activity->name = $request->input('name');
        $activity->save();
        return response()->json(['message' => 'User successfully added activity']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $activity = Activity::all();
        return $activity;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(activity $activity)
    {
        //
    }
}
