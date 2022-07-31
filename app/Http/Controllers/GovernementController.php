<?php

namespace App\Http\Controllers;

use App\Models\Governement;
use App\Models\Trip;

use Illuminate\Http\Request;

class GovernementController extends Controller
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
    public function addGov(Request $request)
    {
        $governement=new Governement;
        $governement->name=$request->name;
        $governement->save();
        return response()->json(['message' => 'User successfully add governement']);
    }

    public function selectGov($trip_id,$gov_id)
    {
        $trip = Trip::find($trip_id);
        $governement = Governement::find($gov_id);
        $trip->governements()->attach($governement->id);
        $tripGovs = $trip->governements;
      
            $trip= $tripGovs->name ;
           // $gov_id++;
        
       return $trip;
        //return response()->json(['message' => 'User successfully select governement']);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\governement  $governement
     * @return \Illuminate\Http\Response
     */
    public function show(governement $governement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\governement  $governement
     * @return \Illuminate\Http\Response
     */
    public function edit(governement $governement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\governement  $governement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, governement $governement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\governement  $governement
     * @return \Illuminate\Http\Response
     */
    public function destroy(governement $governement)
    {
        //
    }
}
