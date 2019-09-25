<html>
<head>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .card1 {

            margin-top: 150px;
            margin-left: 530px;
            width: 600px;
        }

        .card1 input {
            width: 300px;
        }

        .card1 button {
            margin-left: 120px;
        }


    </style>
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
          rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="code.jquery.com/jquery-1.10.2.min.js"></script>

    <script>
        //the script below will load the preview of the image in a div which has an id of image_preview
        if (window.FileReader) {
            function handleFileSelect(evt) {
                var files = evt.target.files;
                var f = files[0];
                var reader = new FileReader();

                reader.onload = (function (theFile) {
                    return function (e) {
                        document.getElementById('image_preview').innerHTML = ['<img class="the_img_prev" src="', e.target.result, '" title="', theFile.name, '">'].join('');
                    };
                })(f);

                reader.readAsDataURL(f);
            }
        } else {
            alert('This browser does not support FileReader');
        }

        //the script will make the link act like a file selector
        document.getElementById('files_selector').addEventListener('change', handleFileSelect, false);
    </script>

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <meta charset=utf-8/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <!-- jQuery Modal -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="card1">


    <img style="" src="/instagram/storage/app/profile/{{$user['profile']}}" height="170px" width="170px"/>
    &nbsp&nbsp&nbsp&nbsp

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Change
        Profile
    </button>
    <br>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="image" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="file" id="files_selector" name="image" accept="image/*" style="display:none;"
                               onchange="form.submit();">
                        <a class="list-group-item list-group-item-action" href="#" class="image_selector"
                           id="image_selector" onclick="document.getElementById('files_selector').click();">
                            <center>Select from gallery</center>
                        </a>
                    </form>
                    <a href="{{route('delete.profile',$user['username'])}}"
                       class="list-group-item list-group-item-action" style="color: #a71d2a">
                        <center>Remove</center>
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <br>

    <form method="post" action="">
        {{csrf_field()}}
        <Label for="username">Username</Label>
        <input value="{{$user['username']}}" name="username" type="text" class="form-control" id="username"
               placeholder="Enter username"><br>

        <Label for="username">Password</Label>
        <input value="{{$user['password']}}" name="password" type="password" class="form-control" id="username"
               placeholder="Enter password"><br>

        <label for="exampleInputEmail1">Bio</label>
        <textarea value="{{$user['bio']}}" style="width: 300px" name="bio" class="form-control" id="exampleInputEmail1"
                  aria-describedby="emailHelp" placeholder="Enter Bio"></textarea>
        <br>
        <br>
        <label style="float: left" for="private">Private Account:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
        <label class="switch">

            <input type="checkbox" <?php if($user['private']==1) echo "checked" ?>  id="private" name="private">
            <span class="slider round"></span>
        </label>

        <br>
        <br>
        <br>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>

    @include('errors')
</div>


</body>
</html>