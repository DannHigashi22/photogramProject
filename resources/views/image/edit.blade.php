@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
               <div class="card-header">Editar Imagen</div>
               <div class="card-body ">
                    <div class="img-home">
                        <img src="{{ route('image-get',['filename'=>$image->image_path]) }}" alt="">
                    </div>
                   <form action="{{route('image-update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="image_id" value="{{$image->id}}">
                    <div class="form-group row">
                        <label for="imagen" class="col-md-3 col-form-label text-md-right " >Imagen</label>
                        <div class="col-md-7">
                            <input type="file" name="image" id="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                            
                            @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right">Descripcion</label>
                        <div class="col-md-7">
                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" cols="30" rows="10" required>{{$image->description}}</textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('description')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <input type="submit" class="btn btn-primary" value="Editar imagen">
                        </div>
                    </div>
                   </form>
               </div>
           </div>
        </div>
    </div>
</div>
@endsection
