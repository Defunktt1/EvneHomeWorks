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
<div class="container text-center">
    <input list="search-input" placeholder="search" id="search"/>
    <datalist id="search-input">

    </datalist>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-9" id="text">
            <?php printf($data['text'][0]["text"]) ?>
        </div>
        <div id="searches" class="col-md-3" style="border-left: solid 0.5px darkgrey">
            <div style="min-height: 240px">
                <?php
                foreach ($data['searches'] as $search):
                    echo $search['query_string'] . '<br>';
                endforeach;
                ?>
            </div>
            <div>
                <ul class="pagination" id="pagination">
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $().ready(function () {
        appendQuery();
        let searchInput = $('#search');
        let query;
        (searchInput).keypress(function (e) {
            if (e.keyCode === 13) {
                query = searchInput.val();
                searchInput.val('');
                $.ajax({
                    url: "/hw1/search/updated/",
                    data: {"query": query},
                    type: "POST",
                    async: false
                }).done(function (result) {
                    let text = $('#text');
                    text.empty();
                    text.append(result);
                });
                $('#search-input').empty();
                appendQuery();
            }
        });
    });

    function appendQuery() {
        $.ajax({
            url: "/hw1/search/getall/",
            type: 'POST',
            dataType: 'json',
            async: false
        }).done(function (result) {
            let resultCount = result.length;
            let paginationPage = new URL(window.location.href);
            paginationPage = paginationPage.search.split('=')[1];
            $('#pagination').empty();
            for (let i = 0; i < resultCount / 10; i++) {
                if (paginationPage == (i + 1)) {
                    $('#pagination').append('<li class="page-item active"><a class="page-link" href="hw1?page=' + (i + 1) + '">' + (i + 1) + '</a></li>');
                } else {
                    $('#pagination').append('<li class="page-item"><a class="page-link" href="hw1?page=' + (i + 1) + '">' + (i + 1) + '</a></li>');
                }

            }
            let uniqueArray = [];
            result.forEach(function (element) {
                if (!uniqueArray.includes(element['query_string'])) {
                    uniqueArray.push(element['query_string']);
                }
            });

            uniqueArray.forEach(function (element) {
                $('#search-input').append("<option value='" + element + "'>");
            });
        })
    }

</script>
</body>
</html>