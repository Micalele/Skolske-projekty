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
        echo "Zoznam mien:<br><br>";
        $date = date("md", strtotime($_POST["date"]));
        $page = file_get_contents('http://localhost/zadanie6/server/api/names?date=' . $date);
        $json = json_decode($page);
        //var_dump($json);
        if ($json->SK != ""){
            echo "SK: " . $json->SK . "<br>";
        }
        if ($json->SKd != ""){
            echo "SKd: " . $json->SKd . "<br>";
        }
        if ($json->CZ != ""){
            echo "CZ: " . $json->CZ . "<br>";
        }
        if ($json->HU != ""){
            echo "HU: " . $json->HU . "<br>";
        }
        if ($json->PL != ""){
            echo "PL: " . $json->PL . "<br>";
        }
        if ($json->AT != ""){
            echo "AT: " . $json->AT . "<br>";
        }
        ?>
    </div>
</body>
</html>