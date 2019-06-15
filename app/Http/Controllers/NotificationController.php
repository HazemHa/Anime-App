<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\Notification as NotificaitonRequest;
use App\Http\Resources\Notificaiton as NotificaitonJson;
class NotificationController extends Controller
{


    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return NotificaitonJson::collection(Notification::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificaitonRequest $request)
    {
        $request->validated();
        $notify = new Notification;
        $notify->sender_id = \Auth::user()->id;
        $notify->receiver_id = $request->receiver_id;
        $notify->body = $request->body;
        return $this->handlerResult($notify->save());
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(NotificaitonRequest $request, $notification_id)
    {
        //
        $notify =  Notification::find($notification_id);
        $notify->sender_id = \Auth::user()->id;
        $notify->receiver_id = $request->receiver_id;
        $notify->body = $request->body;
        return $this->handlerResult($notify->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($notification_id)
    {
        $notify = Notification::destroy($notification_id);
        return $this->handlerResult($notify);
    }
}
