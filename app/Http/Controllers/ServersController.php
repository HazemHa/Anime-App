<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use App\Http\Requests\Servers as ServersRequest;
use App\Http\Resources\Servers as JsonServer;
class ServersController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return JsonServer::collection(Server::all());
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServersRequest $request)
    {
        //.
        $request->validated();
        $server = new Server;
        $server->episode_id = $request->episode_id;
        $server->server_name = $request->server_name;
        $server->episode_link = $request->episode_link;
        $server->server_type = $request->server_type;
        return $this->handlerResult($server->save());
    }

  
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DownloadsServer  $downloadsServer
     * @return \Illuminate\Http\Response
     */
    public function update(ServersRequest $request, $server_id)
    {
        //
        $server = Server::find($server_id);
        $server->episode_id = $request->episode_id;
        $server->server_name = $request->server_name;
        $server->episode_link = $request->episode_link;
        $server->server_type = $request->server_type;
        return $this->handlerResult($server->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DownloadsServer  $downloadsServer
     * @return \Illuminate\Http\Response
     */
    public function destroy($server_id)
    {
        //
        $server = Server::destroy($server_id);
        return $this->handlerResult($server);
    }
}
