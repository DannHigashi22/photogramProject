<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function upload(Request $request){

        $validate=$this->validate($request,[
            'description'=>['required','max:255'],
            'image'=>['required','mimes:jpg,jpeg,png']
        ]);
        
       $description=$request->input('description');
       $image_pth=$request->file('image');
    
       $user=\Auth::user()->id;
       $image=new Image();
       $image->user_id=$user;
       $image->description=$description;

       if ($image_pth) {
           $image_name=time().$image_pth->getClientOriginalName();
           Storage::disk('images')->put($image_name,\File::get($image_pth));
           $image->image_path=$image_name;
       }

       $image->save();

       return \redirect()->route('home')->with(['message'=>'Imagen subida correctamente']);
    }

    public function getImage($filename){
        $file=Storage::disk('images')->get($filename);
        return \response($file,200);
    }

    public function detail($id){
        $image=Image::find($id);
        return view('image.detail',['image'=>$image]);
    }

    public function delete($id){
        $user=\Auth::user();
        $image=Image::find($id);
        
        if ($user && $image && $image->user->id==$user->id) {
            //eliminar likes
            $image->likes()->delete();
            //eliminar commentarios
            $image->comments()->delete();
            
            //eliminar imagen del disco
            \Storage::disk('images')->delete($image->image_path);

            //eliminar imagen
            $image->delete();

            $message='Imagen eliminada correctamente';
            
        }else{
            $message='Error al borrar imagen';
        }

        return \redirect()->route('home')->with(['message'=>$message]);
    }
    public function edit($id){
        $user=\Auth::user();
        $image=Image::find($id);

        if ($user && $image && $image->user->id==$user->id ) {
            return view('image.edit',['image'=>$image]);
        }else {
            return \redirect()->route('home');
        }
    }

    public function update(Request $request){
        $validate=$this->validate($request,[
            'description'=>['required','max:255'],
            'image'=>['mimes:jpg,jpeg,png']
        ]);
        //recoger datos
        $image_id=$request->input('image_id');
        $description=$request->input('description');
        $image_path=$request->file('image');

        $image=Image::find($image_id);
        $image->description=$description;


        if ($image_path) {
            $image_name=time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_name,\File::get($image_path));
            $image->image_path=$image_name;
        }

        //actualizar
        $image->update();

        return \redirect()->route('image-detail',['id'=>$image_id])->with(['message'=>'Imagen actualizada correctamente']);
        
    }
}
