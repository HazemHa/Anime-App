<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserJson;
use Auth;
use App\Http\Resources\Episode as EpisodeJson;
use App\Episode;
class SPAController extends Controller
{
    //

    public function index(){

        return view('page');
    }

    public function login(Request $request)
    {
         // set access token for use
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $token = Auth::user()->createToken('remember_token')->accessToken;
            Auth::user()->remember_token = $token;
            Auth::user()->save();
            return response()->json(['authUser' => new UserJson(Auth::user()),'token'=> $token]);

        }

        return response()->json(['error' => 'please confirm form credentials ']);

    }

    public function logout(Request $request){
        if (Auth::user()->accessTokens->count() > 0) {
            Auth::user()->accessTokens()->delete();
        }
        Auth::user()->remember_token = "null";
        return $this->handlerResult(Auth::user()->save());
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => \Hash::make($request['password']),
        ]);

        Auth::loginUsingId($user->id);
        $token = Auth::user()->createToken('remember_token')->accessToken;
        Auth::user()->remember_token = $token;
        Auth::user()->save();
        return response()->json(['authUser' => new UserJson(Auth::user()),'token'=>$token]);
    }

    public function lastEpisodes(){
        return EpisodeJson::collection(Episode::where('created_at', '>', \Carbon\Carbon::now()->subDays(300))->get());
    }

    public function lasItemAdded(){
        return new EpisodeJson(
            Episode::where('created_at', '>', \Carbon\Carbon::now()->subHours(12))->first() == null ?
            Episode::inRandomOrder()->first():
            Episode::where('created_at', '>', \Carbon\Carbon::now()->subHours(150))->first());

    }
}
