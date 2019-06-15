<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Favorite;
use App\Comment;
use App\Like;
use Validator;
use App\Http\Resources\User as UserJson;
use App\Http\Resources\Favorite as FavoriteJson;

class UserController extends Controller
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
        return ['user'=>new UserJson(\Auth::user()), 'token' => \Auth::user()->remember_token];
    }
    public function userActivity($typeActivity){
        if($typeActivity == $this->comments){
            \Auth::user()->load('comments');
            return new UserJson(\Auth::user());
        }else if($typeActivity == $this->likes){
            \Auth::user()->load('likes');
            return new UserJson(\Auth::user());
        } else if ($typeActivity == $this->favorites) {
            \Auth::user()->load('favorites');
            return new UserJson(\Auth::user());
        }

    }
   

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $validator = Validator::make(
            $request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $user = User::find($id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = \Hash::make($request['password']);
        if ($request->hasFile('avater')) {
            $path = $request->file('avater')->store('public/profiles');
            $user->avater = $path;
        }

        return $this->handlerResult($user->save());
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return $this->handlerResult($user);
    }
}
