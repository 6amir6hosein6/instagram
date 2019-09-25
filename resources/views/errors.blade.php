@if($errors->any())
    @foreach($errors->all() as $error)
        <h3 style="color: #880000">{{$error}}</h3>
    @endforeach
@endif