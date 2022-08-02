<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Trip;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use app\Http\Controllers\Response;


class AreaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
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
    public function addArea(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'description' => 'required|string|max:255',
                'image1' => 'required|image',
                'image2' => 'required|image',
                'image3' => 'required|image'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        $request->image1->store('public/uploads/');
        $request->image2->store('public/uploads/');
        $request->image3->store('public/uploads/');
        $area = new Area;
        $area->name = $request->name;
        $area->country = $request->country;
        $area->city = $request->city;
        $area->description = $request->description;

        $request->image1->store('public/uploads/');
        $area->image1 = $request->image1->hashName();
        $area->image2 = $request->image2->hashName();
        $area->image3 = $request->image3->hashName();
        $area->save();
        return response()->json([
            'message' => 'admin successfully added an area', 'area' => $area
        ], 201);
    }


    public function updateArea(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string|max:50',
                'country' => 'string|max:50',
                'city' => 'string|max:50',
                'description' => 'string|max:255',
                'image1' => 'image',
                'image2' => 'image',
                'image3' => 'image'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $area = Area::find($id);
        if (!$area) {
            return response()->json(['error' => 'not found'], 404);
        }
        $request->image1->store('public/uploads/');
        $request->image2->store('public/uploads/');
        $request->image3->store('public/uploads/');
        $area->update([
            'name' => $request->input('name'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'description' => $request->input('description'),
            'image1' => $request->image1->hashName(),
            'image2' => $request->image2->hashName(),
            'image3' => $request->image3->hashName(),
        ]);
        $area->save();
        return response()->json([
            'message' => 'admin successfully addes an area', 'area' => $area
        ], 201);
    }

    public function selectCountry_City(Request $request, $trip_id)
    {
        $trip = Trip::find($trip_id);
        $tripAreas = $trip->areas;
        $fitCountries = $request->get('country');
        $fitCities = $request->get('city');
        $areas = Area::where('country', 'LIKE', '%' . $fitCountries . '%')->where('city', 'LIKE', '%' . $fitCities . '%')->get();
        $areaName = $request->get('name');
        //$area = Area::find($area_id);
        // $trip->areas()->attach($area->id);
        return response()->json(array(
            'areas' => $areas,
        ));
    }

    public function selectArea($trip_id, $area_id)
    {
        $trip = Trip::find($trip_id);
        $area = Area::find($area_id);
        if (!$area) {
            return response()->json(['error' => 'not found'], 404);
        }
        $trip->areas()->attach($area->id);
        return response()->json(['success' => 'the area was selected'], 200);
    }

    public function deselectArea($trip_id, $area_id)
    {
        $trip = Trip::find($trip_id);
        $area = Area::find($area_id);
        if (!$area) {
            return response()->json(['error' => 'not found'], 404);
        }
        $trip->areas()->detach($area->id);
        return response()->json(['success' => 'the area was deselected'], 200);
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
