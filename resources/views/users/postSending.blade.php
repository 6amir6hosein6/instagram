<html>
<head>
    <style>
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
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <meta charset=utf-8/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>


<div class="card1">
    @include('errors')
    <br>
    <form id="image" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" id="files_selector" name="file" accept="image/* video/*" style="display:none;">
        <a href="#" class="image_selector"
           id="image_selector" onclick="document.getElementById('files_selector').click();">
            >Select Image or Video
        </a>

        <br><br>

        <label for="exampleInputEmail1">Caption</label>
        <textarea style="width: 300px" name="caption" class="form-control" id="exampleInputEmail1"
                  aria-describedby="emailHelp" placeholder="Enter Bio">
        </textarea>

        <br><br>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>
</html>