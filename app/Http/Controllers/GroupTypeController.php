<?php

namespace App\Http\Controllers;

use App\GroupType;
use Illuminate\Http\Request;
use App\Http\Resources\GroupType as JsonGroupType;
use App\Http\Requests\GroupTypeRquest;
class GroupTypeController extends Controller
{
    
    function __construct(){
        $this->middleware(
            'auth',
            ['only' =>
                ['update', 'store', 'destroy']]
        );
    }
    public function index()
    {
        //
        return JsonGroupType::collection(GroupType::all());
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupTypeRquest $request)
    {
        //
        $request->validated();
        try{
        $groupType = new GroupType;
        $groupType->name = $request->name;
        $groupType->description = $request->description;
        return $this->handlerResult($groupType->save());
        }catch(\Illuminate\Database\QueryException $e){
           return $this->errorMessage($e);
        }
        
    }

   
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupType  $groupType
     * @return \Illuminate\Http\Response
     */
    public function update(GroupTypeRquest $request,$groupType_id)
    {
        try {
            $request->validated();
            $groupType = GroupType::find($groupType_id);
            $groupType->name = $request->name;
            $groupType->description = $request->description;
            return $this->handlerResult($groupType->save());

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupType  $groupType
     * @return \Illuminate\Http\Response
     */
    public function destroy($groupType_id)
    {
        //
        return $this->handlerResult(GroupType::destroy($groupType_id));


    }
}
