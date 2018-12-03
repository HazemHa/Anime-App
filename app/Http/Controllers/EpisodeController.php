<?php

namespace App\Http\Controllers;

use App\Episode;
use Illuminate\Http\Request;
use App\Http\Requests\Episode as EpisodeRequest;
use App\Http\Resources\Episode as JsonEpisode;
class EpisodeController extends Controller
{


    function __construct()
    {
        $this->middleware(
            'auth',
            ['only' =>
                ['update', 'store', 'destroy']]
        );
    }

    public function index()
    {
     //   return dd(Episode::find(14)->comments);
        return JsonEpisode::collection(Episode::paginate(5));
    }
    public function detailEpisode($id){
        $detail = Episode::find($id)->load('servers');
        return new JsonEpisode($detail);
    }
    public function detailGroup($id){
        $detailGroup = Episode::where('group_id',$id)->paginate(10);
        return JsonEpisode::collection($detailGroup);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpisodeRequest $request)
    {
        //.
        $request->validated();
        try{
        $Episode = new Episode;
        $Episode->group_id = $request->group_id;
        $Episode->uploaded_by = \Auth::user()->id;
        $Episode->number = $request->number;
        $Episode->description = $request->description;
        $Episode->image = $request->image;
        $result = $Episode->save();
        return response()->json(['episode_id'=>$Episode->id, 
        $this->handlerResult($result)]);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }

    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function update(EpisodeRequest $request, $episode_id)
    {
        //
        try{
        $Episode = Episode::findOrFail($episode_id);
        $Episode->group_id = $request->group_id;
        $Episode->uploaded_by = \Auth::user()->id;
        $Episode->number = $request->number;
        $Episode->description = $request->description;
        if($request->hasFile('image')){
        $path = $request->file('image')->store('public/episodes');
        $Episode->image = $path;
        }
        return $this->handlerResult($Episode->save());
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy($episode_id)
    {
        //
        $Episode =  Episode::destroy($episode_id);;
        return $this->handlerResult($Episode);
    }
    
}
