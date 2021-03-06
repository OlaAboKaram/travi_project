<?php

namespace App\Http\Controllers;

use App\Models\state;
use App\Models\Trip;

use Illuminate\Http\Request;

class StateController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addState(Request $request)
    {
        $state=new State;
        $state->name=$request->name;
        $state->save();
        return response()->json(['message' => 'User successfully add state']);
    }

    public function selectState($trip_id,$state_id)
    {
        $trip = Trip::find($trip_id);
        $state = State::find($state_id);
        $trip->states()->attach($state->id);
        $tripStates = $trip->states;
        foreach($tripStates as $tripState)
        {
            echo $tripState->name . '  ';
        }
        
        return response()->json(['message' => 'User successfully select state']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function show(state $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(state $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, state $state)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(state $state)
    {
        //
    }
}
