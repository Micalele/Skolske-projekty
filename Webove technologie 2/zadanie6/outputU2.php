<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body id="top10perc">
<div class="ramcek">
    <?php
    $page = file_get_contents("http://localhost/zadanie6/server/api/dates?country=" . $_POST["country"] . "&name=" . $_POST["name"]);
    $json = json_decode($page);
    //var_dump($json);
    if ($json->den != ""){
        echo $_POST["name"] . " ma meniny ";
        if ($json->den[2] != "0")  echo $json->den[2];
        echo $json->den[3] . ".";
        if ($json->den[0] != "0")  echo $json->den[0];
        echo $json->den[1] . ". ";
    }
    ?>
</div>
</body>
</html>