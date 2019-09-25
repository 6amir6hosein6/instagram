<?php
$i =0;
?>
<!doctype html>
<html lang="en">
    <head>
        <style>
            #bottom_nav button{
                border: none;
                background-color: #fff;
                outline: none;
            }

            .dropbtn {
                background-color: #3498DB;
                color: white;
                padding: 16px;
                font-size: 16px;
                border: none;
            }

            .dropup {
                position: relative;
                display: inline-block;
            }

            .dropup-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 450px;
                bottom: 50px;
                z-index: 1;
            }

            .dropup-content div {
                color: black;
                padding: 12px 16px;
                /*text-decoration: none;*/
                display: block;
            }

            .dropup-content div:hover {background-color: #ccc}

            .show {display: block;}

            .dropup:hover .dropbtn {
                background-color: #2980B9;
            }
            body {font-family: Arial, Helvetica, sans-serif;}

            .centered button{
                border: none;
                background-color: #fff;
                outline: none;
            }

            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
            #search_filed{
                margin-left: 550px;
                text-align: center;
                height: 20px;
            .centered {

                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }

            /* Style the image inside the centered container, if needed */
            .centered img {
                width: 400px;
                height: 400px;
            }
            ul#list_suggest{
                list-style: none;
                margin: 0px;
                padding: 0px;
                width: 200px;
            }

            ul#list_suggest li a{

                display: block;
                min-height: 1em;
                padding: 0.5em  20px;
                background-color: #ccc;
                color: #000;
                text-decoration: none;
            }

        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <body>

        {{--top menu--}}
        <nav class="navbar navbar-light bg-light">

            <form class="form-inline" method="post" action="">
                {{csrf_field()}}
                <input name="search_username" id="search_filed" class="form-control mr-sm-2" onkeyup="suggest()" type="text" placeholder="Search" aria-label="Search">
            </form>
            <a  class="navbar-brand" href="{{route('user.logout')}}">Logout</a>
        </nav>


        <div id="suggests" class="container" style="width: 300px;position: absolute;margin-left: 550px;display: none">
            <div class="list-group" id="inside_suggest">
                <a href="#" class="list-group-item">First item</a>
            </div>
        </div>
        {{--posts--}}
        <br><br>
{{--        {{dd($posts->toArray()[  0]->media)}}--}}
      @foreach($data['posts'] as $post)

            <div class="centered" style="padding-top:30px;width: 460px;padding-left:30px;margin-left:425px;border-style: solid;border-width: 1px;border-color:black">
                <?php
                    $i++;
                    $like = App\models\like::where([
                            ['username', '=', $_COOKIE['signed']],
                            ['media', '=', $post->media],
                    ]);
                    $z = $like->get()->toArray();
                    $liked = 0;
                    if(!empty($z)){
                        $liked=1;
                    }
                    $media = $post->id;
                ?>
                <img  style="width: 400px;
                height: 400px;" src="/instagram/storage/app/post/{{$post->media}}" alt="{{$post->caption}}"><br>
                @if($liked)
                    <?php echo '<button style="margin-right: 377px;color: red;" id="1"   onclick="like('.$media.','.$media.')" class="navbar-brand but"><label style="color: black" id="'.$media.'">'.$post->like.'</label><i class="far fa-heart"></i></button>' ?>
                @else
                    <?php echo '<button style="margin-right: 377px;color: black" id="0"  onclick="like('.$media.','.$media.')" class="navbar-brand but"><label style="color: black" id="'.$media.'">'.$post->like.'</label><i class="far fa-heart"></i></button>' ?>

                @endif
                <a style="text-align: left" href="{{route('username',$post->user_username)}}"> <h5>{{$post->user_username}}</h5> </a>
                <p style="text-align: left">{{$post->caption}}</p>
            </div>
            <br>
        @endforeach
        <br><br><br>

        {{--bottom menu--}}
        <nav id="bottom_nav" style="padding: 0 550px" class="navbar fixed-bottom navbar-light bg-light">
            <a  id="but" class="navbar-brand" href="{{route('user.home')}}"><i class="fas fa-home"></i></a>
            <button  id="but" class="navbar-brand" href="#"><i class="fas fa-search"></i></button>
            <a  id="but" class="navbar-brand" href="{{route('user.sendingPost')}}"><i class="far fa-sticky-note"></i></a>

            <div class="dropup">
                @if($data['red']==0)
                    <button id="but1" onclick="myFunction()" class="navbar-brand dropbtn"><i class="far fa-heart"></i></button>
                @else
                    <button style="color:red;" id="but1" onclick="myFunction()" class="navbar-brand dropbtn"><i class="far fa-heart"></i></button>
                @endif
                <div class="dropup-content" id="myDropdown">
                    @if(!is_null($data['notification']))

                    @foreach($data['notification'] as $notification)
                    <div style="border-style: solid;border-width: 1px;border-color:black">
                        <p><a href="{{route('username',$notification->from_username)}}"><img src="/instagram/storage/app/profile/{{$notification->profile}}" alt="alt text" style="float: left;width: 40px;height: 40px;"></a>
                            &nbsp&nbsp{{$notification->from_username}}
                            @if(explode(":",$notification->kind)[0]=="like")
                                <label>liked your post</label>
                                <a href="{{route('showPost',explode(":",$notification->kind)[1])}}">
                                    <img src="/instagram/storage/app/post/{{explode(":",$notification->kind)[1]}}" alt="alt text" style="float: right;width: 40px;height: 40px;">
                                </a>
                            @elseif(explode(":",$notification->kind)[0]=="follow")
                                <label>start following you</label>
                            @elseif(explode(":",$notification->kind)[0]=="request")
                                <label>request for following</label>
                                <button  id="{{$notification->id}}" onclick="asked_request_yes(this.id)" alt="yes" style="float: right;width: 40px;height: 40px; background-color: #007bff">yes</button>
                                &nbsp&nbsp&nbsp
                                <button id="{{$notification->id}}" onclick="asked_request_no(this.id)" alt="no" style="width: 40px;height: 40px; background-color: #880000">no</button>

                            @endif

                        </p>

                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <a  class="navbar-brand" href="{{route('username',$_COOKIE['signed'])}}"><i class="far fa-user"></i></a>

        </nav>

        <div id="myModal" class="modal">

            <div id="mod" class="modal-content">
                <span class="close">&times;</span>
                <p>Some text in the Modal..</p>
            </div>

        </div>
        <script type="text/javascript">

            function suggest() {

                var x = document.getElementById('search_filed').value;
                var xx = document.getElementById('suggests');
                console.log(x);
                if(x.length>=3){
                    document.getElementById("inside_suggest").innerHTML = '<img style="width:70px;height: 70px;margin-left:80px" class="list-group-item" src="/instagram/storage/loading.gif"/>';
                    var text = '{}';
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET','search/'+x, true);
                    xhr.onreadystatechange = function () {
                        if(xhr.readyState == 2) {

                        }
                        if(xhr.readyState == 4 && xhr.status == 200) {
                            text = xhr.responseText;
                            console.log('respons : '+text);
                            jj  = JSON.parse(text);
                            var a_list = '';
                            for (i=0;i<jj.length;i++){
                                a_list += '<a href="'+jj[i].username+'" class="list-group-item" style="width:300px;margin-left:0px"><img style="width:70px;height: 70px;margin-left:80px"  src="/instagram/storage/app/profile/'+jj[i].profile+'"/>'+jj[i].username+'</a>';
                            }
                            console.log('a_list : '+a_list);
                            document.getElementById("inside_suggest").innerHTML = a_list;
                        }
                    }
                    xhr.send();

                    xx.style.display = 'block';
                }else{
                    xx.style.display = 'none';
                }

            }

            function like(like_post,id) {
                //console.log(id);
                //console.log(like_post);
                var label = document.getElementById(id);
                var button = label.parentNode;
                var liked = button.id;

                var url;
                console.log(liked);
                if(liked == "0"){
                    url = 'likeid/'+like_post;
                    button.setAttribute("id","1");

                }else{
                    url = 'unlikeid/'+like_post;
                    button.setAttribute("id","0");
                }
                console.log(url);
                console.log(liked);
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.onreadystatechange = function () {
                    if(xhr.readyState == 2) {
                    }
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);

                        if(xhr.responseText=="liked"){
                            var x = document.getElementById(id).innerHTML;
                            var xx = parseInt(x);
                            xx++;
                            document.getElementById(id).innerHTML = xx;
                            button.setAttribute("style", "margin-right: 377px;color :red;");

                        }else{
                            var x = document.getElementById(id).innerHTML;
                            var xx = parseInt(x);
                            xx--;
                            document.getElementById(id).innerHTML = xx;
                            button.setAttribute("style", "margin-right: 377px;color:black");

                        }


                    }
                }
                xhr.send();
            }
            function asked_request_yes(not_id){
                var xhr = new XMLHttpRequest();
                xhr.open('GET','askedRequest/yes/'+not_id, true);
                xhr.onreadystatechange = function () {
                    if(xhr.readyState == 2) {
                    }
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                        var remove = document.getElementById(not_id).parentNode.parentNode;
                        remove.parentNode.removeChild(remove);
                    }
                }
                xhr.send();
            }
            function asked_request_no(not_id){
                var xhr2 = new XMLHttpRequest();
                xhr2.open('GET','askedRequest/no/'+not_id, true);
                xhr2.onreadystatechange = function () {
                    if(xhr2.readyState == 2) {
                    }
                    if(xhr2.readyState == 4 && xhr2.status == 200) {
                        console.log(xhr2.responseText);
                        var remove = document.getElementById(not_id).parentNode.parentNode;
                        remove.parentNode.removeChild(remove);
                    }
                }
                xhr2.send();
            }
        </script>
        <script>
            function myFunction() {
                var button = document.getElementById("but1");
                document.getElementById("myDropdown").classList.toggle("show");

                var xhr = new XMLHttpRequest();
                xhr.open('GET',"notification/seen", true);
                xhr.onreadystatechange = function () {
                    if(xhr.readyState == 2) {
                    }
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                        button.setAttribute("style","color:black;")
                    }
                }
                xhr.send();
            }
            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
