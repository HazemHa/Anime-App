<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\Group as GroupRequest;
use App\Http\Resources\Group as JsonGroup;
class GroupController extends Controller
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
        return JsonGroup::collection(Group::all());
    }

   
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
       
        $request->validated();
        try {
            $group = new Group;
            $group->writtenBy = \Auth::user()->id;
            $group->group_type_id = $request->group_type_id;
            $group->name = $request->name;
            $group->description = $request->description;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/groups');
                $group->image = $path;
            }

            return $this->handlerResult($group->save());
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }

    }

   
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $group_id)
    {
        try{
        $group = Group::find($group_id);
        $group->writtenBy = \Auth::user()->id;
        $group->name = $request->name;
        $group->description = $request->description;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images');
            $group->image = $path;
        }
        $group->group_type_id = $request->group_type_id;
        return $this->handlerResult($group->save());
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($group_id)
    {
        $group = Group::find($group_id);
        if($group !=null) $group->forceDelete();
        return $this->handlerResult($group);
    }

  
}
