@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card home">
                <div class="card-header">
                    @if ($search)
                        Resultados de la busqueda: {{$search}}
                    @else
                        Conoce a mas Usuarios
                    @endif     
                </div>
                <div class="card-body">
                    @if (!$users->isEmpty())
                        @foreach ($users as $user)     
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-sm-4 col-4">
                                    @if ($user->image)
                                        <div class="overflow-hidden objetfit">
                                            <img src="{{url('/user/avatar',$user->image)}}" alt="avatar de usuario" class="img-thumbnail rounded-circle">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-7 col-sm-7 col-7">
                                    <a href="{{route('user-profile',['id'=>$user->id])}}"><p class="p-nick">{{'@'.$user->nick}}</p></a>
                                    <p>{{$user->name.' '.$user->surname}}</p>
                                    <p>{{$user->created_at->diffForHumans(null, false, false, 1)}}
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <div class="row justify-content-center">
                            <p> No se encontraron resultados para : {{$search}}</p>
                        </div>
                    @endif
                </div>
            </div>
            {{--paginacion--}}
            <div class="clearfix"></div>
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection