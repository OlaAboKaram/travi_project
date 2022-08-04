<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Area;
use App\Models\Comment;

use App\Models\Governement;
use App\Models\Activity;
use Illuminate\Validation\ValidationException;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Auth;
use willvincent\Rateable\Rateable;
use dnsimmons\openweather\OpenWeather;
use RakibDevs\Weather\Weather;

use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use willvincent\Rateable\Rating as RateableRating;


class UserAreaController extends Controller
{
    use Rateable;

    public function __construct()
    {
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

 

    public function show_area($id)
    {
        $area = Area::find($id);
        $areaInfo[] =  $area;

        $area->likeCount;
        $area->comments;

        if (!$area) {
            return response()->json(['error' => 'no areas'], 404);
        } else {
            return $areaInfo;
        }
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
        $result[] =  $areaComments;
        $areaImage = $area->image1;
        $result[] =  $areaImage;

        if (!$areaComments) {
            return response()->json(['error' => 'there is no comment'], 404);
        }
        return $result;
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
