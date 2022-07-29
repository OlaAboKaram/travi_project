<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Trip;

use Illuminate\Http\Request;
use app\Http\Controllers\Response;


class AreaController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
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
        $uploadedImages=$request->image1->store('public/uploads/');
        $uploadedImages=$request->image2->store('public/uploads/');
        $uploadedImages=$request->image3->store('public/uploads/');
        $area=new Area;
        $area->name=$request->name;
        $area->description=$request->description;
        $area->image1= $request->image1->hashName();
        $area->image2= $request->image2->hashName();
        $area->image3= $request->image3->hashName();
        $area->save();
        return  $area; 
    }

    public function selectCountry_City(Request $request,$trip_id)
    {
        $trip = Trip::find($trip_id);
        $tripAreas = $trip->areas;
        $fitCountries = $request->get('country');
        $fitCities = $request->get('city');
        $areas=Area::where('country', 'LIKE', '%'. $fitCountries. '%')->where( 'city', 'LIKE', '%'. $fitCities. '%')->get();
        $areaName= $request->get('name');      
        //$area = Area::find($area_id);
       // $trip->areas()->attach($area->id);
       return response()->json(array(
        'areas' => $areas,       
     ));
    }

    public function selectArea($trip_id,$area_id)
    {
        $trip = Trip::find($trip_id);
        $area = Area::find($area_id);
        $trip->areas()->attach($area->id);
        return response()->json(['success' => 'the area was selected'], 200);
    }

    public function deselectArea($trip_id,$area_id)
    {
        $trip = Trip::find($trip_id);
        $area = Area::find($area_id);
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
