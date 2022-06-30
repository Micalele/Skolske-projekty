<?php
if (!empty($_SERVER["HTTP_CLIENT_IP"])){
    $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else{
    $ipAddress = $_SERVER["REMOTE_ADDR"];
}
?>
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
    echo "<br>IP adresa: " . $ipAddress . "<br>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/" . $ipAddress);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch));
    //var_dump($response);
    curl_close($ch);
    echo "Suradnice: Lat-" . $response->lat . ", Lon-" . $response->lon . "<br>";
    echo "Mesto: " . $response->city . "<br>";
    echo "Štát: " . $response->country . "<br>";
    $stat = $response->country;
    $statCode = $response->countryCode;
    $mesto = $response->city;
    $cas = date("Y-m-d H:i:s",time());
    $lat =$response->lat;
    $lon = $response->lon;
    $sposob = 2;

    include "conf.php";
    try {
        $conn = new PDO("mysql:host=localhost;dbname=zadanie7;charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "<br>";
    }
    $query = "INSERT INTO `z7`(`ip`, `stat`, `statCode`, `mesto`, `cas`, `lat`, `lon`, `sposob`) VALUES ('" . $ipAddress .  "','" . $stat .  "','" . $statCode .  "','" . $mesto .  "','" . $cas .  "'," . $lat .  "," . $lon .  "," . $sposob .  ")";
    //echo $query;
    $result = $conn->query($query);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v2/alpha/" . $response->countryCode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch));
    //var_dump($response);
    curl_close($ch);

    echo "Hlavné mesto tohoto štátu: " . $response->capital . "<br>";
    ?>
    <a href="http://147.175.121.210:8143/zadanie7/povolene.html"> <br>Go back</a>
</div>
</body>
</html>
