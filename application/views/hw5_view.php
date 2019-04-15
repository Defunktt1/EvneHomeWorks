<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<textarea id="text"></textarea>
<button type="submit" id="analyz">Submit</button>
<div id="analyz-result"></div>
</body>
</html>

<script>
    $().ready(function() {
        $('#analyz').click(function() {
            let text = $('#text').val();
            $.ajax({
                url: "/analyz-text/",
                data: {"text": text},
                type: "POST",
                async: false
            }).done(function (result) {
                let $json = JSON.parse(result);
                $('#analyz-result').empty();
                $('#analyz-result').append(
                    "<p>Индекс удобочитаемости текста: " + $json["readability"] +"</p>" +
                    "<p>Динамичный темп: " + $json["speed"][0] + " секунд</p>" +
                    "<p>Нормальный темп: " + $json["speed"][1] + " секунд</p>" +
                    "<p>Комфортный темп: " + $json["speed"][2] + " секунд</p>" +
                    "<p id='tags'></p>"
                );
            });
            $.ajax({
                url: "https://apis.paralleldots.com/v4/taxonomy",
                data: {"text": text, "api_key": "0wkCTKyUZyiA66DD2xABZ42ciXDm0HYY9oiSYTSOMvg"},
                type: "POST",
                async: false
            }).done(function(result) {
                let tags = "Классификация текста: ";
                result["taxonomy"].forEach(function(tag) {
                    tags += tag["tag"] + ". ";
                });
                $('#tags').text(tags);
            }).fail(function(result) {
                console.log(result);
            });
        });
    });
</script>