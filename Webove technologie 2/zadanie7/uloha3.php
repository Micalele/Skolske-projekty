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

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/" . $ipAddress);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = json_decode(curl_exec($ch));
curl_close($ch);
$stat = $response->country;
$statCode = $response->countryCode;
$mesto = $response->city;
$cas = date("Y-m-d H:i:s",time());
$lat =$response->lat;
$lon = $response->lon;
$sposob = 3;

include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie7;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
$query = "INSERT INTO `z7`(`ip`, `stat`, `statCode`, `mesto`, `cas`, `lat`, `lon`, `sposob`) VALUES ('" . $ipAddress .  "','" . $stat .  "','" . $statCode .  "','" . $mesto .  "','" . $cas .  "'," . $lat .  "," . $lon .  "," . $sposob .  ")";
$result = $conn->query($query);

$zoznamStatov = array();
$zoznamIP = array();
$query = "SELECT * FROM z7";
$i = $conn->query($query);
//L.marker([48.154127, 17.076838]).addTo(myMap);
$markery = "";
while ($result = $i->fetch()){
    array_push($zoznamStatov, $result[1]);
    array_push($zoznamIP, $result[0]);
    $markery = $markery . "L.marker([" . $result[5] . ", " . $result[6] . "]).addTo(mymap);";
}
$zoznamStatov = array_unique($zoznamStatov);
$zoznamIP = array_unique($zoznamIP);

?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="leaflet/leaflet.css" />
    <script src="leaflet/leaflet.js"></script>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<div class="ramcek">
    <div>
        <?php
        $query = "SELECT COUNT(*) FROM `z7` WHERE sposob=1";
        $sposob1 = $conn->query($query)->fetch();
        $query = "SELECT COUNT(*) FROM `z7` WHERE sposob=2";
        $sposob2 = $conn->query($query)->fetch();
        $query = "SELECT COUNT(*) FROM `z7` WHERE sposob=3";
        $sposob3 = $conn->query($query)->fetch();
        echo "Počet navštívenia stránok:<br>Stránka úlohy č.1 - " . $sposob1[0] . " navštívení<br>Stránka úlohy č.2 - " . $sposob2[0] . " navštívení<br>Stránka úlohy č.3 - " . $sposob3[0] . " navštívení";
        ?>
    </div>
    <table>
        <thead>
        <tr>
            <th>Vlajka</th>
            <th>Stat</th>
            <th>Pocet</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($zoznamStatov as $item){
            $kolkoKrat = 0;
            $query = "SELECT `stat`, `statCode` FROM `z7` WHERE stat = '" . $item . "'";
            $result = $conn->query($query)->fetch();
            echo "<tr>";
            echo "<td><img style='height: 20px' src='http://www.geonames.org/flags/x/" . strtolower($result[1]) .".gif'></td>";
            //http://147.175.121.210:8143/zadanie7/uloha3b.php?stat=
            echo "<td><a href='http://147.175.121.210:8143/zadanie7/uloha3b.php?stat=" . $result[0] . "'>"  . $result[0] . "</a></td>";
            foreach ($zoznamIP as $ip){
                $query = "SELECT `cas` FROM `z7` WHERE stat = '" . $item . "' AND ip='"  . $ip . "'";
                $result = $conn->query($query);
                $casi = array();
                while($resultC = $result->fetch()){
                    array_push($casi, $resultC[0]);
                }
                if (!empty($casi)){
                    for ($x = 0; $x < sizeof($casi); $x++){
                        $casi[$x] = strtotime($casi[$x]);
                        $casi[$x] = date("Y-m-d", $casi[$x]);
                    }
                    $casi = array_unique($casi);
                    $kolkoKrat = $kolkoKrat + sizeof($casi);
                }
            }
            echo "<td>"  . $kolkoKrat . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <div id="myMap" style="height: 500px; width: 40%"></div>
    <script>
        let mymap = L.map('myMap').setView([48.151381, 17.071984], 16);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWljYWxlIiwiYSI6ImNrM3p4NWxjYzEwMXUzcnM4bjQ5N2R4eGkifQ.2JmXdWWPCFwM5AJ5UujDWw', {
            id: 'mapbox/streets-v11',
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);
        <?php echo $markery;?>
    </script>
    <a href="http://147.175.121.210:8143/zadanie7/povolene.html"> <br>Go back</a>
</div>
</body>
</html>