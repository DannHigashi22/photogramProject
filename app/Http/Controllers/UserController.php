<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($search=null){
        if (!empty($search)) {
            $users=User::where('nick','LIKE','%'.$search.'%')
                        ->orWhere('name','LIKE','%'.$search.'%')
                        ->orWhere('surname','LIKE','%'.$search.'%')
                        ->orderBy('id','desc')->paginate(5);
        }else {
            $users=User::orderBy('id','desc')->paginate(5);    
        }
        return view('user.users',['users'=>$users,'search'=>$search]);
    }

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        $user=\Auth::user();
        $id=$user->id;
        $validate=$this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255',"unique:users,nick,$id"],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$id"]
        ]);

        $name=$request->input('name');
        $surname=$request->input('surname');
        $nick=$request->input('nick');
        $email=$request->input('email');

        $user->name=$name;
        $user->surname=$surname;
        $user->nick=$nick;
        $user->email=$email;

        $image=$request->file('image');
        if ($image) {
            $image_path_name=time().$image->getClientOriginalName();
            Storage::disk('users')->put($image_path_name,\File::get($image));
            $user->image=$image_path_name;
        }

        $user->update();
        
        return \redirect()->route('config')->with(['message'=>'Usuario actualizado correctamente']);
    }

    public function getImage($filename){
        $file=Storage::disk('users')->get($filename);
        return \response($file,200);
    }

    public function profile($id){
        $user= User::find($id);
        return view('user.profile',['user'=>$user]);
    }
    
}
