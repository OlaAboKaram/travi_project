<?php

namespace App\Http\Controllers;

use App\Models\Dailyprogram;
use App\Models\Dateday;
use Illuminate\Http\Request;

class DateDayController extends Controller
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
    public function addDay(Request $request,$id)
    {
        $dailyprogram = Dailyprogram::find($id);
        $dateday=new Dateday();
        $dateday->name=$request->input('name');
        $dateday->description=$request->input('description');
        $dateday->day=$request->input('day');
        $dateday->save();
        $dailyprogram= $dailyprogram->datedays()->save($dateday);
        return  $dateday;
        //
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
