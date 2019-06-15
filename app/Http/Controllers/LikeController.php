<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\Like as LikeJson;
class LikeController extends Controller
{




    function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        return LikeJson::collection(\Auth::user()->likes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LikeRequest $request)
    {
        // 'likestable_id', 'likestable_type'
        $request->validated();
        $like = Like::where([['user_id',\Auth::user()->id],['likestable_id', $request->likestable_id]])->first();
        if($like == null)
        $like = new Like;

        $like->user_id = \Auth::user()->id;
        $like->likestable_id = $request->likestable_id;
        $like->likestable_type = $this->getType($request->likestable_type);
        return $this->handlerResult($like->save());
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(LikeRequest $request, $like_id)
    {
        //
        $like = Like::find($like_id);
        $like->user_id = \Auth::user()->id;
        $like->likestable_id = $request->likestable_id;
        $like->likestable_type = $request->likestable_type;
        return $this->handlerResult($like->save());
    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy($like_id)
    {
        //
        $like = Like::where([['user_id', \Auth::user()->id], ['likestable_id', $like_id]])->first();

        $result = Like::destroy($like->id);
        return $this->handlerResult($result);
    }
}
