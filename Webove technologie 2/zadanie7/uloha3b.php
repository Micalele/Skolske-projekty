<?php
include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie7;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
$query = "SELECT * FROM `z7` WHERE stat='" . $_GET["stat"] . "'";
$result = $conn->query($query);
$vysledok = array();
while ($x = $result->fetch()){
    array_push($vysledok, $x);
}
$zoznamMiest = array();
$zoznamIP = array();
foreach ($vysledok as $item){
    array_push($zoznamMiest, $item[3]);
    array_push($zoznamIP, $item[0]);
}
$zoznamMiest = array_unique($zoznamMiest);
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
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body id="top10perc">
<div class="ramcek">
    <table>
        <thead>
        <tr>
            <th>Mesto</th>
            <th>Pocet</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($zoznamMiest as $item){
            $kolkoKrat = 0;
            echo "<tr>";
            echo "<td>" . $item . "</td>";
            foreach ($zoznamIP as $ip){
                $query = "SELECT `cas` FROM `z7` WHERE mesto = '" . $item . "' AND ip='"  . $ip . "'";
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
    <a href="http://147.175.121.210:8143/zadanie7/uloha3.php"> Go back</a>
</div>
</body>
</html>
