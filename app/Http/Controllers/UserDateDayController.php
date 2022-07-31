<?php

namespace App\Http\Controllers;

use App\Models\Dailyprogram;
use App\Models\Dateday;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserDateDayController extends Controller
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
    


    public function show_days($id)
    {
        $dailyprogram = Dailyprogram::find($id);
        if (!$dailyprogram) {
            return response()->json(['error' => 'not found'], 404);
        }
        return  $dailyprogram->datedays;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Date_Day  $date_Day
     * @return \Illuminate\Http\Response
     */
    public function show(Dateday $date_Day)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Date_Day  $date_Day
     * @return \Illuminate\Http\Response
     */
    public function edit(Dateday $date_Day)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Date_Day  $date_Day
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dateday $date_Day)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Date_Day  $date_Day
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dateday $date_Day)
    {
        //
    }
}
