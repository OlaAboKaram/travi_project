<?php

namespace App\Http\Controllers;

use App\Models\Dailyprogram;
use App\Models\Trip;
use Illuminate\Http\Request;

class DailyProgramController extends Controller
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
    public function addDailyProgram(Request $request,$id)
    {
        $trip = Trip::find($id);
        if (!$trip) {
            return response()->json(['error' => 'not found'], 404);
        }
        $dailyprogram=new Dailyprogram();
        $dailyprogram->save();
        $trip = $trip->dailyprograms()->save($dailyprogram);
        $trip->save();
        return response()->json(['success' => 'the daily program was created'], 200);
    }

    public function delete_dailyprogram($id)
    {
        $dailyprogram = Dailyprogram::find($id);
        if (!$dailyprogram) {
            return response()->json(['error' => 'not found'], 404);
        }
        $result = $dailyprogram->delete();
        if ($result) {
            return response()->json(['success' => 'the dailyprogram was deleted'], 200);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
