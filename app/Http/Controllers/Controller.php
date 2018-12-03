<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $episode = "ee";
    protected $gorup = "gp";
    protected $comments = "comments";
    protected $likes = "likes";
    protected $favorites = "favorites";

    public function handlerResult($result){
        if($result){
            return response()->json(['success'=>'the task done successfully']);
        }

        return response()->json(['error' => 'the task failure try again ']);
    }
    public function errorMessage(\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        if ($errorCode =='1062') {
            return response()->json(['error' => "these data are entered before !!"]);

        }
    }

    public function getType($type){
      
        if ($type === $this->episode) {
           return 'App\Episode';
        } else if ($type === $this->gorup) {
            return  'App\Group';
        }
    }

    public function isSafeToken($Token){
        return \Auth::user()->remember_token === $Token;
    }  

}
