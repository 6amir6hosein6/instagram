<html>
<head>
    <style>
        #but{
            text-align: left;
            border: none;
            background-color: #fff;
            outline: none;
        }

        .user_name{
            font-size:14px;
            font-weight: bold;
        }
        .comments-list .media{
            border-bottom: 1px dotted #ccc;
        }
        .split {
            position: fixed;
            top: 0;
            overflow-x: hidden;
        }

        /* Control the left side */
        .left {
            height: 100%;
            width: 65%;
            left: 0;

        }

        /* Control the right side */
        .right {

            height: 100%;
            width: 35%;
            right: 0;
            background-color: #95999c;
        }

        /* If you want the content centered horizontally and vertically */
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
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>
<body>
    <div class="split left">
        <div class="centered">

            <img src="/instagram/storage/app/post/{{$data['post']['media']}}" alt="{{$data['post']['caption']}}">
                @if($data['liked'])
                    <button style="margin-right: 377px;color: red;" id="but" class="navbar-brand"><label style="color: black" id="like_num">{{$data['post']['like']}}</label><i class="far fa-heart"></i></button>
                @else
                    <button style="margin-right: 377px;color: black" id="but" class="navbar-brand"><label style="color: black" id="like_num">{{$data['post']['like']}}</label><i class="far fa-heart"></i></button>
                @endif
            <a style="text-align: left" href="#"> <h5>{{$data['post']['user_username']}}</h5> </a>
            <p style="text-align: left">{{$data['post']['caption']}}</p>
        </div>
    </div>






    <div class="split right">
                <div class="row">
                    <div class="col-md-8">
                        <div class="page-header">
                            <h1><small class="pull-right">45 comments</small> Comments </h1>
                        </div>
                        <div class="comments-list">
                            <div class="media">
                                <p class="pull-right"><small>5 days ago</small></p>
                                <a class="media-left" href="#">
                                    <img style="width: 50px;height: 50px" src="/instagram/storage/app/post/trees.png">
                                </a>
                                <div class="media-body">

                                    <h4 class="media-heading user_name">Baltej Singh</h4>
                                    Wow! this is really great.

                                    <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                                </div>
                            </div>
                            <div class="media">
                                <p class="pull-right"><small>5 days ago</small></p>
                                <a class="media-left" href="#">
                                    <img style="width: 50px;height: 50px" src="/instagram/storage/app/profile/anon.jpg">
                                </a>
                                <div class="media-body">

                                    <h4 class="media-heading user_name">Baltej Singh</h4>
                                    Wow! this is really great.

                                    <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                                </div>
                            </div>
                            <div class="media">
                                <p class="pull-right"><small>5 days ago</small></p>
                                <a class="media-left" href="#">
                                    <img style="width: 50px;height: 50px" src="/instagram/storage/app/post/trees.png">
                                </a>
                                <div class="media-body">

                                    <h4 class="media-heading user_name">Baltej Singh</h4>
                                    Wow! this is really great.

                                    <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
    </div>
    <script type="text/javascript">
        var like_post = "<?php echo $data['post']['media'] ?>";
        var liked = "<?php echo $data['liked'] ?>";
        function like() {
            var url;
            console.log(liked);
            if(liked == "0"){
                url = 'like/'+like_post;
                liked ="1";
            }else{
                url = 'unlike/'+like_post;
                liked ="0";
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
                        document.getElementById("but").setAttribute("style", "margin-right: 377px;color :red;");
                        var x = document.getElementById("like_num").innerHTML;
                        var xx = parseInt(x);
                        xx++;
                        var x = document.getElementById("like_num").innerHTML = xx;
                    }else{
                        document.getElementById("but").setAttribute("style", "margin-right: 377px;color:black");
                        var x = document.getElementById("like_num").innerHTML;
                        var xx = parseInt(x);
                        xx--;
                        var x = document.getElementById("like_num").innerHTML = xx;
                    }


                }
            }
            xhr.send();
        }

        var button = document.getElementById ("but");
        button.addEventListener("click", like);




    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>