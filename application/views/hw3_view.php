<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
    </script>
    <title>Document</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="files list-group">
                <?php
                foreach ($data as $file) {
                    if ($file !== '.') {
                        echo '<a href="#" class="list-group-item list-group-item-action link-element">' . $file . '</a>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="file-content"></div>
        </div>
    </div>
</div>
</body>

</html>

<script>
    // preventDefault for links
    $(document).on('click', '.link-element', function (e) {
        e.preventDefault();
    });

    // double click
    $(document).on('dblclick', '.link-element', function (e) {
        let fileContent = $('.file-content');
        let filesBlock = $('.files');
        e.preventDefault();
        let path = $(this).text();
        if (path === '..') {
            $.ajax({
                url: "/hw3/back/",
                type: "GET",
                dataType: "json",
            }).done(function (result) {
                filesBlock.empty();
                result.forEach(function (element) {
                    filesBlock.append('<a href="#" class="list-group-item list-group-item-action link-element">' + element + '</a>');
                    fileContent.empty();
                });
            });
        } else {
            $.ajax({
                url: "/hw3/scanoropen/",
                type: 'GET',
                data: {'path': path},
                dataType: 'json',
            }).done(function (result) {
                if (typeof result == 'object') {
                    filesBlock.empty();
                    result.forEach(function (element) {
                        filesBlock.append('<a href="#" class="list-group-item list-group-item-action link-element">' + element + '</a>');
                        fileContent.empty();
                    });
                } else if (typeof result == 'string') {
                    if (result === "Can not read this file") {
                        fileContent.empty();
                        fileContent.append('<p class="h2">Can not read this file</p>')
                    } else {
                        fileContent.empty();
                        fileContent.append('<textarea class="form-control" rows="20" cols="50" id="file-content-edit"></textarea>');
                        $('#file-content-edit').text(result);
                        fileContent.append('<button class="btn btn-primary" id="save">Save changes</button>');
                        fileContent.append('<button class="btn btn-primary float-right" id="close">Close</button>');
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                }
            });
        }
    });

    // save changes
    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        let text = $('#file-content-edit').val();
        $.ajax({
            type: "POST",
            url: "/hw3/save/",
            data: {'text': text},
        }).done(function () {
            $('.file-content').empty();
        });
    });

    // close window
    $(document).on('click', '#close', function (e) {
        e.preventDefault();
        $('.file-content').empty();
    })
</script>