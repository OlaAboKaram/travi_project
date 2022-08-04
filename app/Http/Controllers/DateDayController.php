<?php

namespace App\Http\Controllers;

use App\Models\Dailyprogram;
use App\Models\Dateday;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


class DateDayController extends Controller
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
    public function addDay(Request $request, $id)
    {
        $dailyprogram = Dailyprogram::find($id);

        if (!$dailyprogram) {
            return response()->json(['error' => 'not found'], 404);
        }
        try {
            $dateday = new Dateday();
            $request->validate([
                'description' => 'required|string|max:255',
                'day' => 'required|date',
            ]);
            $dateday->description = $request->input('description');
            $dateday->day = $request->input('day');
            $day = Carbon::createFromFormat('Y-m-d',  $dateday->day)->format('l');
            $dateday->name = $day;
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $dateday->save();
        $dailyprogram = $dailyprogram->datedays()->save($dateday);
        return response()->json(['success' => 'the day was added', 'day' => $dateday], 201);

        //
    }

    public function updateDay(Request $request, $id, $day_id)
    {
        $dailyprogram = Dailyprogram::find($id);
        $dateday = Dateday::find($day_id);
        if (!$dailyprogram || !$dateday) {
            return response()->json(['error' => 'not found'], 404);
        }
        try {
            $request->validate([
                'name' => 'string|max:50',
                'description' => 'string|max:255',
                'day' => 'date',
            ]);

            //  $dateday->update($request->all());
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $input = $request->all();
        $dateday->fill($input)->save();
        $dailyprogram = $dailyprogram->datedays()->save($dateday);
        return response()->json(['success' => 'the day was updated', 'day' => $dateday], 201);

        //
    }

    public function show_days($id)
    {
        $dailyprogram = Dailyprogram::find($id);
        $tripDailyProgram = $dailyprogram->trip_id;
        $trip = Trip::find($tripDailyProgram);
        //  $tripdays = $trip->end_trip - $trip->start_trip;
        $start_trip = Carbon::parse($trip->start_trip);
        $end_trip = Carbon::parse($trip->end_trip);
        $tripdays = $start_trip->diffInDays($end_trip, false);

        if (!$dailyprogram) {
            return response()->json(['error' => 'not found'], 404);
        }
        return response()->json(['daysNumber' => $tripdays, 'days' => $dailyprogram->datedays], 200);
    }


    public function delete_dateday($id)
    {

        $dateday = Dateday::find($id);
        if (!$dateday) {
            return response()->json(['error' => 'not found'], 404);
        }
        $result = $dateday->delete();
        if ($result) {
            return response()->json(['success' => 'the dateday was deleted'], 200);
        }
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
