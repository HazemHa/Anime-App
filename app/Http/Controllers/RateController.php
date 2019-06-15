<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Rating;
use App\Http\Resources\Rating as RatingJson;
class RateController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        return RatingJson::collection(Rating::all());
    }

   
    public function store(RatingRequest $request)
    {
        //
        $request->validated();
        $rating = Rating::where([['rating_id', $request->rating_id], ['user_id', \Auth::user()->id]])->first();
       if($rating == null)
        $rating = new Rating;
       
       $rating->rating_id = $request->rating_id;
        $rating->user_id = \Auth::user()->id;
        $rating->rating_type = $this->getType($request->rating_type);
        $rating->count = $request->count;
        return $this->handlerResult($rating->save());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* 
    public function update(Request $request, $id)
    {
        //
        $rating = Rating::where([['rating_id',$request->id],['user_id',\Auth::user()->id]])->first();
        $rating->user_id = \Auth::user()->id;
        $rating->rating_id = $request->rating_id;
        $rating->rating_type = $request->rating_type;
        $rating->count = $request->count;
        return $this->handlerResult($rating->save());
    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $rating = Rating::where([['rating_id', $request->id], ['user_id', \Auth::user()->id]])->first();
        return $this->handlerResult(Rating::destroy($rating->id));
    }
}
