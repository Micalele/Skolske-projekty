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
    $date = date("md", strtotime($_POST["date"]));
    $page = file_get_contents("http://localhost/zadanie6/server/api/vlozitMeno?meno=" . $_POST["name"] .  "&den=" . $date);
    $page = json_decode($page);
    echo "Meno " . $_POST["name"] . "pridane";
    ?>
</div>
</body>
</html>