<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Http\Response;
use App\Like;

class LikeController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function like($image_id){
        $user=\Auth::user();

        //comprobar su existe el like
        $isset=Like::where('user_id',$user->id)->where('image_id',$image_id)->count();
        if ($isset==0) {
            $like= new Like();
            $like->user_id=$user->id;
            $like->image_id=(int)$image_id;

            $like->save();

            return response()->json(['like'=> $like]);
        }else{
            return response()->json(['message'=> 'accion no permitida']);
        }
    }

    public function dislike($image_id){
        $user=\Auth::user();

        //comprobar su existe el like
        $like=Like::where('user_id',$user->id)->where('image_id',$image_id)->first();
        if ($like) {
            $like->delete();

            return response()->json([
                'like'=> $like]);
        }else{
            return response()->json(['message'=> 'accion no permitida']);
        }
    }

    public function likes(){
        $user=\Auth::user();
        $likes= Like::where('user_id',$user->id)->orderBy('id','desc')->paginate(5);
        return view('like.likes',[
            'likes'=> $likes
        ]);
    }

}
