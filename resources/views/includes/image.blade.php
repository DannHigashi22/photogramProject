<div class="card home">
    <div class="card-header">
    @if ($image->user->image)
        <div class="container-avatar">
            <img src="{{url('/user/avatar',$image->user->image)}}" alt="avatar de usuario" class="avatar">
        </div>
    @endif
        <a href="{{route('user-profile',['id'=>$image->user->id])}}"><p class="p-nick">{{'@'.$image->user->nick}}</p></a>
    </div>
    <div class="card-body">
        <div class="img-home">
            <a href="{{route('image-detail',['id'=>$image->id])}}">
                <img src="{{ route('image-get',['filename'=>$image->image_path]) }}" alt="">
            </a>
        </div>
        <div class="likes">
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
        <div class="description">
            <p>{{$image->user->nick}}: {{$image->description}}</p>
        </div>
        <a href="{{route('image-detail',['id'=>$image->id])}}" class="btn btn-warning btn-comments">Comentario {{'('.count($image->comments).')'}}</a>
        {{$image->created_at->diffForHumans(null, false, false, 1)}}
    </div>
</div>