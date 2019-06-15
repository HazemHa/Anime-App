<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Resources\Setting as JsonSetting;
use App\Http\Requests\SettingRequest;
class SettingController extends Controller
{

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return JsonSetting::collection(Setting::all());

    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        //
        try{
        $request->validated();
        $setting = new Setting;
        $setting->key = $request->key;
        $setting->value = $request->value;
        $result = $setting->save();
        return response()->json(['response'=>['IDItemAdded'=>$setting->id],'result'=>$this->handlerResult($result)]);
    } catch (\Illuminate \Database \QueryException $e) {
        return $this->errorMessage($e);
    }
    }

   

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request,$setting)
    {
        //
        try{
        $request->validated();
        $setting = Setting::find($setting);
        $setting->key = $request->key;
        $setting->value = $request->value;
        return $this->handlerResult($setting->save());
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($setting)
    {
        //
        $setting = Setting::find($setting);
        return $this->handlerResult(Setting::destroy($setting->id));
    }
}
