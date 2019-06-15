<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use App\Http\Requests\FavoriteRequest;
use App\Http\Resources\Favorite as FavoriteJson;
class FavoriteController extends Controller
{


    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return FavoriteJson::collection(\Auth::user()->favorites);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavoriteRequest $request)
    {
        // 'user_id', 'favoritetable_id', 'favoritable_type'
        $request->validated();
        $favorite = Favorite::where([['user_id',\Auth::user()->id],['favoritetable_id',$request->favoritetable_id]])->first();
        if($favorite == null)
        $favorite = new Favorite;

        $favorite->user_id = \Auth::user()->id;
        $favorite->favoritetable_id = $request->favoritetable_id;
        $favorite->favoritetable_type = $this->getType($request->favoritetable_type);
        return $this->handlerResult($favorite->save());

    }

  


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(FavoriteRequest $request, $favorite_id)
    {
        //
        $favorite =  Favorite::find($favorite_id);
        $favorite->user_id = \Auth::user()->id;
        $favorite->favoritetable_id = $request->favoritetable_id;
        $favorite->favoritetable_type = $request->favoritetable_type;
        return $this->handlerResult($favorite->save());
    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy($favorite_id)
    {
        //
        $favorite = Favorite::where([['user_id', \Auth::user()->id], ['favoritetable_id', $favorite_id]])->first();
        $result = Favorite::destroy($favorite->id);
        return $this->handlerResult($result);
    }
}
