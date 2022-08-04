<?php

namespace App\Http\Controllers;

use App\Models\Dateday;
use App\Models\Event;
use App\Models\Dailyprogram;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserEventController extends Controller
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
    public function addEvent(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'required|string|max:50',
                'timing' => 'required|string|max:50',
                'image' => 'required|image|max:2000',
            ]);
            $dateday = Dateday::findOrFail($id);
            $event = new Event();
            $event->name = $request->input('name');
            $event->description = $request->input('description');
            $event->timing = $request->input('timing');

            //image//
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $event['image'] = $filename;
            //
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $event->save();
        $dateday = $dateday->events()->save($event);
        return response()->json(['message' => 'the event was add successfully', 'event' => $dateday], 404);
    }

    public function show_event_details(Request $request, $id){
        $dailyprogram=Dailyprogram::find($id);
        $dayEvents=array();
        $days=$dailyprogram->datedays;
        foreach($days as $day){
            $dayEvents[]=$day->events;
        }
        return $days;
       // $dateday = Dateday::find($id);
      // $dayEvents= $dateday->events;

      /*  return $dailyprogramEvents= $dailyprogram->events();
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);
        $date=$request->input('date');
        foreach($dailyprogramEvents as $dailyprogramEvents){
            $dateday= Dateday::where('day','=',$date)->get();
        }*/
       
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'not found'], 404);
        }
        $result = $event->delete();
        if ($result) {
            return response()->json(['success' => 'the event was deleted'], 200);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
