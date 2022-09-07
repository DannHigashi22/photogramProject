<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        $validate=$this->validate($request,[
            'image'=> ['int','required'],
            'content'=> ['string','required']
        ]);

        $content=$request->input('content');
        $image_id=$request->input('image');
        $user_id=\Auth::user()->id;

        $comments=new Comment();
        $comments->content=$content;
        $comments->image_id=$image_id;
        $comments->user_id=$user_id;

        $comments->save();

        return redirect()->route('image-detail',['id'=>$image_id])->with(['complete'=>'Comentario añadido correctamente']);
    }

    public function delete($id){
        $user=\Auth::user();
        $comment=Comment::find($id);

        //comprabar dueño del comentario
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            $comment->delete();
            return redirect()->route('image-detail',['id'=>$comment->image->id])->with(['complete'=>'Comentario borrado correctamente']);
        }
        else {
            return redirect()->route('image-detail',['id'=>$comment->image->id])->with(['complete'=>'fallo al eliminar comentario']);
        }
    }
}
