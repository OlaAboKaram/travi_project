<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Activity;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AdminActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        //
    }



    public function select_trip_activities(Request $request, $id)
    {
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


    public function deselect_trip_activities(Request $request, $id)
    {
        $trip = Trip::find($id);
        $activities = array();
        $activities = $request->input('activities');
        foreach ($activities as $Thisactivity) {
            $activity = Activity::where('name', 'LIKE', '%' . $Thisactivity . '%')->select('id')->get();
            $trip->activities()->detach($activity);
        }
        return response()->json([
            'message' => 'This activity was deleted to the trip',
        ], 201);
    }

    public function show_activities()
    {
        $user = auth()->user();
        $allActivities = Activity::all();
        $validator = validator();
        if ($allActivities->isEmpty()) {
            return response()->json([
                'message' => 'there is no activities',
            ], 404);
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
    public function Admin_add_activity(Request $request)
    {
        $activity = new Activity;
        try {
            $request->validate([
                'name' => 'required|string|max:50'
            ]);
            $activity->name = $request->input('name');
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        $activity->save();
        return response()->json(['message' => 'Admin successfully added activity'], 200);
    }

    public function Admin_update_activity(Request $request, $id)
    {
        try {
            $activity =  Activity::find($id);
            if (!$activity) {
                return response()->json(['error' => 'activity is not found'], 404);
            }
            $input = $request->validate([
                'name' => 'required|string|max:5'
            ]);
            $activity->update(['name' => $request->input('name')]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        $activity->save();
        return response()->json(['message' => 'Admin successfully updated activity'], 200);
    }

    public function delete_activity($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['error' => 'not found'], 404);
        }
        $result = $activity->delete();
        if ($result) {
            return response()->json(['success' => 'the activity was deleted'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\activity  $activity
     * @return \Illuminate\Http\Response
     */


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
