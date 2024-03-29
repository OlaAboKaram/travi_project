<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Area;
use App\Models\Comment;

use App\Models\Governement;
use App\Models\Activity;
use Illuminate\Validation\ValidationException;

use App\Models\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use dnsimmons\openweather\OpenWeather;
use RakibDevs\Weather\Weather;

use App\Models\Rating;
use willvincent\Rateable\Rating as RateableRating;


class AreaController extends Controller
{
    use Rateable;

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
                'image3' => 'required|image',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',

            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }


        $area = new Area;
        $area->name = $request->name;
        $area->country = $request->country;
        $area->city = $request->city;
        $area->description = $request->description;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        //image1//
        $file = $request->file('image1');
        $filename1 = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename1);
        $area['image1'] = $filename1;
        //

        //image2//
        $file = $request->file('image2');
        $filename2 = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename2);
        $area['image2'] = $filename2;
        //

        //image3//
        $file = $request->file('image3');
        $filename3 = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename3);
        $area['image3'] = $filename3;
        //
        $area->save();
        return response()->json([
            'message' => 'admin successfully added an area', 'area' => $area
        ], 201);
    }

    public function likeArea($id)
    {
        $area = Area::find($id);
        $user = auth()->user()->id;
        $area->like($user);
        $area->save();
        return $area->likeCount;
    }

    public function dislikeArea($id)
    {
        $area = Area::find($id);
        $user = auth()->user()->id;
        $area->unlike($user);
        $area->save();
        return $area->likeCount;
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


        $input = $request->all();
        $area->fill($input)->save();
        return response()->json([
            'message' => 'admin successfully addes an area', 'area' => $area
        ], 201);
    }

    public function show_areas()
    {
        $areas = Area::all();
        $areaInfo[] =  $areas;
        foreach ($areas as $area) {
            $arealike = $area->likeCount;
            $areaInfo[] = $area->comments;
        }

        if (!$area) {
            return response()->json(['error' => 'no areas'], 404);
        } else {
            return $areaInfo;
        }
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
    public function show_area_like($id)
    {
        $likes = DB::table('likeable_likes')->where('likeable_id', '=', $id)->get();
        foreach ($likes as $like) {
            $users[] = $like->user_id;
        }
        $userinfo = array();
        foreach ($users as $user) {
            $userinfo[] = User::where('id', '=', $user)->get()->pluck('id', 'image');
        }
        return $userinfo;
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

    public function Comments(Request $request, $id)
    {
        $area = Area::find($id);
        $input = $request->all();
        $request->validate([
            'body' => 'required',
        ]);

        $input['user_id'] = auth()->user()->id;
        $input['area_id'] = $area->id;
        return Comment::create($input);
    }


    public function ShowComments($id)
    {
        $area = Area::find($id);
        $areaComments = $area->comments;
        if (!$areaComments) {
            return response()->json(['error' => 'there is no comment'], 404);
        }
        return $areaComments;
    }

    public function deleteComments($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'there is no comment'], 404);
        } else {
            $comment->delete();
            return response()->json(['message' => 'the comment was deleted'], 200);
        }
    }

    public function updateComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        $request->validate([
            'body' => 'required',
        ]);
        $comment->update($request->all());
        return response()->json(['meassage' => 'the comment was upadated', 'comment' =>  $comment], 201);
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
