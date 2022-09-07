@if (Auth::user()->image)
    <div class="container-avatar">
        <img src="{{url('/user/avatar',Auth::user()->image)}}" alt="avatar de usuario" class="avatar">
    </div>
@endif