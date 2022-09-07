@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-4 col-4">
                    @if (Auth::user()->image)
                        <div class="overflow-hidden objetfit">
                            <img src="{{url('/user/avatar',Auth::user()->image)}}" alt="avatar de usuario" class="img-thumbnail rounded-circle">
                        </div>
                    @endif
                </div>
                <div class="col-md-7 col-sm-7 col-7">
                    <p>{{'@'.$user->nick}}</p>
                    <p>{{$user->name.' '.$user->surname}}</p>
                    <p>{{$user->created_at->diffForHumans()}}
                </div>
            </div>
            <hr>
            @foreach ($user->images as $image)
                {{--mostrar en card las imagenes--}}
                @include('includes.image',['image'=>$image])
            @endforeach
        </div>
    </div>
</div>
@endsection