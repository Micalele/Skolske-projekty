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
    $page = file_get_contents("http://localhost/zadanie6/server/api/sviatkySK");
    $page = json_decode($page);
    echo "SLOVENSKE SVIATKY<br>";
    foreach ($page as $item){
        if ($item->den[2] != "0")  echo $item->den[2];
        echo $item->den[3] . ".";
        if ($item->den[0] != "0")  echo $item->den[0];
        echo $item->den[1] . ". ";

        echo " - " . $item->sviatkySK . "<br>";
    }
    ?>
</div>
</body>
</html>