<?php
//api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid=70f72c8e29a63743056fb60ded112d5c
if (!empty($_SERVER["HTTP_CLIENT_IP"])) $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
else $ipAddress = $_SERVER["REMOTE_ADDR"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/" . $ipAddress);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = json_decode(curl_exec($ch));
$lat = $response->lat;
$lon = $response->lon;
//var_dump($response);
curl_close($ch);

$stat = $response->country;
$statCode = $response->countryCode;
$mesto = $response->city;
$cas = date("Y-m-d H:i:s",time());
$lat =$response->lat;
$lon = $response->lon;
$sposob = 1;

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
curl_setopt($ch, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&appid=70f72c8e29a63743056fb60ded112d5c");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = json_decode(curl_exec($ch));
$temp = $response->main->temp - 273.15;
$tempMin = $response->main->temp_min - 273.15;
$tempMax = $response->main->temp_max - 273.15;
$tempFL = $response->main->feels_like - 273.15;
curl_close($ch);
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
<body>
<div id="top10perc">
    <div class="ramcek">
        <?php
        echo "<br>Weather: " . $response->weather[0]->main . ", " . $response->weather[0]->description . "<br>";
        echo "Temperature: " . $temp . " Celsius<br>";
        echo "Minimum temperature: " . $tempMin . " Celsius<br>";
        echo "Maximum temperature: " . $tempMax . " Celsius<br>";
        echo "Temperature feels like: " . $tempFL . " Celsius<br>";
        echo "Pressure: " . $response->main->pressure . "hPa<br>";
        echo "Humifity: " . $response->main->humidity . "%<br>";
        ?>
        <a href="http://147.175.121.210:8143/zadanie7/povolene.html"> <br>Go back</a>
    </div>
</div>
</body>
</html>
