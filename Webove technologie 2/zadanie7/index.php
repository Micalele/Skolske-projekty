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

include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie7;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
$query = "SELECT `ip` FROM `z7`";
$result = $conn->query($query);
while ($ipResult = $result->fetch()){
    if ($ipResult[0] == $ipAddress){
        header("Location: http://147.175.121.210:8143/zadanie7/povolene.html");
        break;
    }
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
    Súhlasím s použitím mojej IP adresy a polohy zariadenia.
    <form action="http://147.175.121.210:8143/zadanie7/povolene.html">
        <input type="submit" value="Súhlasím" />
    </form>
    <form action="http://147.175.121.210:8143/zadanie7/nepovolene.html">
        <input type="submit" value="Nesúhlasím" />
    </form>
</div>
</body>
</html>