<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Activity;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

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
            return response()->json([
                'message' => 'User successfully selected activity',
            ], 201);
        }
    }

    public function delete_user_activities(Request $request)
    {
        $user = auth()->user();
        $activities = array();
        $activities = $request->input('activities');
        foreach ($activities as $Thisactivity) {
            $activity = Activity::where('name', 'LIKE', '%' . $Thisactivity . '%')->select('id')->get();
            $user->activities()->detach($activity);
            return response()->json([
                'message' => 'User successfully deleted activities',
            ], 201);
        }
    }

    public function show_user_activities()
    {
        $user = auth()->user();
        $userActivities= $user->activities;
        if (!$userActivities) {
            return response()->json(['message' => 'there is no activities'], 200);
        }
        else{
            return  $userActivities;
        }
    }

    public function show_activities()
    {
        $user = auth()->user();
        $allActivities = Activity::all();
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
