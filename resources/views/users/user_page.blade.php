<html>
<head>
    <script language="javascript">
        var popupWindow = null;
        function centeredPopup(url,winName,w,h,scroll){
            LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
            TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
            settings =
                    'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
            popupWindow = window.open(url,winName,settings)
        }
    </script>
    <style>


        .btn-default:active .filter-button:active
        {
            background-color: #42B32F;
            color: white;
        }

        .gallery_product
        {

            margin-bottom: 30px;
        }

        #search_filed{
            margin-left: 550px;
            text-align: center;
            height: 20px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>
<body>
@include('top_nav_bar')


<div>
    <br><br><br>
    <center>
    <div class="paragraphs" style="width: 800px">
        <div class="row" style="width: 800px">
            <div class="span4" style="width: 800px" >
                <img style="float:left" src="/instagram/storage/app/profile/{{$data['user'][0]['profile']}}" height="170px" width="170px"/>
                <div class="content-heading">
                    <h3>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        {{$data['user'][0]['username']}}
                        <br><br>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        {{$data['postNumber']}}&nbsp&nbsp post &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$data['followerNumber']}}&nbsp&nbsp follower &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$data['followingNumber']}}&nbsp&nbspfollowing
                        <br>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        @if($data['who']==2)
                            <br>
                            @if($data['followed']==1)
                                <button id="unfollow" onclick="unfollow()" class="btn btn-default" style="width: 300px;border-style: solid;border-width: 2px;border-color:black">Following</button>
                            @elseif($data['followed']==2)
                                <button id="unrequest" class="btn btn-default" onclick="getFollowRequestBack()" style="width: 300px;border-style: solid;border-width: 2px;border-color:black">Requested</button>
                            @else
                                <button id="follow" onclick="follow()" class="btn btn-primary" style="width: 300px">Follow</button>
                            @endif
                        @else
                            <br>
                            <a href="{{route('user.edit',$data['user'][0]['username'])}}"><button class="btn btn-secondary btn-lg active" style="width: 300px">Edit Profile</button></a>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>
    </center>
    <br><br>
    <p style="clear:both;width:400px;margin-left: 270px;">{{$data['user'][0]['bio']}}</p>
    <br><br><br>
</div><br>
<div>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <div class="row">
            <br/>
            @if(array_key_exists('post',$data))
                @foreach($data['post'] as $p)
                    <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe" width="500px" height="500px">
                        <a href="{{route('showPost',$p['media'])}}" onclick="centeredPopup(this.href,'myWindow','700','500','yes');return false">
                            <img src="/instagram/storage/app/post/{{$p['media']}}" class="img-responsive" style="width:500px;height:330px"  >
                        </a>
                    </div>
                @endforeach
            @else
               <center> <h3>This account is private</h3> </center>
            @endif
         </div>
    </div>
    </section>

</div>
<script type="text/javascript">

    var username = "<?php echo $data['user'][0]['username']; ?>";

    function follow() {
        var url;
        url = 'follow/'+username;
        console.log(url);
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 2) {
            }
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);

                if(xhr.responseText=="added"){
                    document.getElementById("follow").setAttribute("style", "width: 300px;border-style: solid;border-width: 2px;border-color:black");
                    document.getElementById("follow").innerHTML = "Following";
                    document.getElementById("follow").className = "btn btn-default";
                    document.getElementById("follow").setAttribute("onclick","unfollow()");
                    document.getElementById("follow").id = "unfollow";
                }else if(xhr.responseText=='asked'){
                    document.getElementById("follow").setAttribute("style", "width: 300px;border-style: solid;border-width: 2px;border-color:black");
                    document.getElementById("follow").innerHTML = "Requested";
                    document.getElementById("follow").className = "btn btn-default";
                    document.getElementById("follow").setAttribute("onclick","getFollowRequestBack()");
                    document.getElementById("follow").id = "unrequest";
                }


            }
        }
        xhr.send();
    }
    function unfollow() {
        url = 'unfollow/'+username;
        console.log(url);

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 2) {
            }
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                document.getElementById("unfollow").setAttribute("style", "width: 300px;border-style: solid;border-width: 2px;border-color:black;");
                document.getElementById("unfollow").innerHTML = "Follow";
                document.getElementById("unfollow").className = "btn btn-primary";
                document.getElementById("unfollow").setAttribute("onclick","follow()");
                document.getElementById("unfollow").id = "follow";
            }
        }
        xhr.send();
    }


    function getFollowRequestBack(){
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getFollowRequestBack/'+username, true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 2) {
            }
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                document.getElementById("unrequest").setAttribute("style", "width: 300px;");
                document.getElementById("unrequest").innerHTML = "Follow";
                document.getElementById("unrequest").className = "btn btn-primary";
                document.getElementById("unrequest").setAttribute("onclick", "follow()");
                document.getElementById("unrequest").id = "follow";
            }
        }
        xhr.send();
    }



</script>
<script>
    $(document).ready(function(){

        $(".filter-button").click(function(){
            var value = $(this).attr('data-filter');

            if(value == "all")
            {
                //$('.filter').removeClass('hidden');
                $('.filter').show('1000');
            }
            else
            {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
                $(".filter").not('.'+value).hide('3000');
                $('.filter').filter('.'+value).show('3000');

            }
        });

        if ($(".filter-button").removeClass("active")) {
            $(this).removeClass("active");
        }
        $(this).addClass("active");

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>