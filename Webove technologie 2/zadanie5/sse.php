<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header("Connection: keep-alive");
header("Access-Control-Allow-Origin: *");

$lastId = $_SERVER["HTTP_LAST_EVENT_ID"];
if (isset($lastId) && !empty($lastId) && is_numeric($lastId)) {
    $lastId = intval($lastId);
    $lastId++;
} else {
    $lastId = 0;
}

include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie5;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}

while (true) {
    $query = "SELECT * FROM `konstanta`";
    $result = $conn->query($query)->fetch();
    $a = $result[0];
    $x = $lastId;

    echo $_GET["y1"];

    $y1=sin(deg2rad($x*$a));
    $y2=cos(deg2rad($x*$a));
    $y3=$y1*$y2;
    echo "id: $lastId" . PHP_EOL;
    echo "data: {". PHP_EOL;
    echo "data: \"x\": \"{$x}\", ". PHP_EOL;

    if ($_GET["y1"] != null){
        if ($_GET["y1"] == "1") echo "data: \"y1\": \"{$y1}\", ". PHP_EOL;
    }
    else echo "data: \"y1\": \"{$y1}\", ". PHP_EOL;

    if ($_GET["y2"] != null){
        if ($_GET["y2"] == "1") echo "data: \"y2\": \"{$y2}\", ". PHP_EOL;
    }
    else echo "data: \"y2\": \"{$y2}\", ". PHP_EOL;

    if ($_GET["y3"] != null){
        if ($_GET["y3"] == "1") echo "data: \"y3\": \"{$y3}\", ". PHP_EOL;
    }
    else echo "data: \"y3\": \"{$y3}\", ". PHP_EOL;

    //echo "data: \"y1\": \"{$y1}\", ". PHP_EOL;
    //echo "data: \"y2\": \"{$y2}\", ". PHP_EOL;
    //echo "data: \"y3\": \"{$y3}\", ". PHP_EOL;
    echo "data: \"a\": \"{$a}\" ". PHP_EOL;
    echo "data: }". PHP_EOL;
    echo PHP_EOL;
    $lastId++;
    ob_flush();
    flush();


    sleep(1);
}
