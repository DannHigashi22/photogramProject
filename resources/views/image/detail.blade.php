@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="card home">
                <div class="card-header">
                    <div class="container-avatar">
                        <img src="{{url('/user/avatar',$image->user->image)}}" alt="avatar de usuario" class="avatar">
                    </div>
                    <p class="p-nick">{{'@'.$image->user->nick}}</p>
                </div>
                <div class="card-body detail">
                    <div class="img-home image-detail">
                        <img src="{{ route('image-get',['filename'=>$image->image_path]) }}" alt="">
                    </div>
                    <div class="likes row justify-content-between">
                        <div class="col-5 ">
                            <?php $user_like=false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user->id==\Auth::user()->id)
                                    <?php $user_like=true; ?>
                                @endif
                            @endforeach
                            @if ($user_like)
                                <img src="{{asset('img/heart1.png')}}" data-id="{{$image->id}}" class="btn-dislike">
                            @else
                                <img src="{{asset('img/heart.png')}}" data-id="{{$image->id}}" class="btn-like">
                            @endif
                            {{'Me Gusta: '.count($image->likes)}}
                        </div>
                        @if (\Auth::user()&& $image->user->id==\Auth::user()->id)
                            <div class="col-7 text-right">
                                <a class="btn btn-warning" href="{{route('image-edit',['id'=>$image->id])}}">Editar</a>
                                <!-- Button del modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                    Borrar
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Estas seguro?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            Si eliminas esta imagen no se podra recuperar, ¿estas de acuerdo?
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <a class="btn btn-danger" href="{{route('image-delete',['id'=>$image->id])}}">Borrar</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="description">
                        <p>{{$image->user->nick}}: {{$image->description}}</p>
                        <p>{{$image->created_at->diffForHumans(null, false, false, 1)}}</p>
                    </div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2>
                        <hr>
                        <form action="{{route('comment-create')}}" method="post">
                            @csrf
                            <input type="hidden" name="image" value="{{$image->id}}">
                            <p>
                                <textarea class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" cols="20" rows="5"  ></textarea>
                                
                                @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('content')}}</strong>
                                </span>
                            @endif
                            </p>
                            <input type="submit" value="Enviar" class="btn btn-success">
                        </form>
                        <hr>
                        @foreach ($image->comments as $comment)
                            <div class="comment">
                                <div class="description">
                                    <div class="float-left">
                                        <p>{{$comment->user->nick}}: {{$comment->content}}</p>
                                        <p>{{$comment->created_at->diffForHumans(null, false, false, 1)}}</p>
                                    </div>
                                    @if (\Auth::check() && ($comment->user_id == \Auth::user()->id || $comment->image->user_id == \Auth::user()->id))
                                        <div class="float-right">
                                            <a href="{{route('comment-delete',['id' =>$comment->id])}}" class="btn btn-small btn-danger ">Borrar</a>
                                        </div>
                                    @endif

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection