<?php
include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie4;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
//NACITAVIE DAT PRE DRUHY CHART
$chart2Coutry = array();
$chart2PercentageCured = array();
$query = "SELECT * FROM `korona` WHERE `update` LIKE '2020-03-21'";
$querySvet = "SELECT * FROM `svet`";
$resultSvet = $conn->query($querySvet);
while($rowSvet = $resultSvet->fetch()){
    //echo $rowSvet[0] . $rowSvet[1] . "<br>";
    $rowSvet[0] = str_replace("'", "''", $rowSvet[0]);
    $query = "SELECT * FROM `korona` WHERE `update` LIKE '2020-03-21' AND `country`='" . $rowSvet[0] . "'";
    $result = $conn->query($query);
    $confirmed = 0;
    $cured = 0;
    while($row = $result->fetch()){
        $confirmed = $confirmed + (int)$row[3];
        $cured = $cured + (int)$row[5];
    }
    //echo "-" . $rowSvet[0] . "<br>-" . $confirmed . "<br>";
    if ($confirmed>0 && $cured>0){
        array_push($chart2Coutry, $rowSvet[0]);
        if (round($cured/$confirmed*100)>1) array_push($chart2PercentageCured, round($cured/$confirmed*100));
        else array_push($chart2PercentageCured, $cured/$confirmed*100);
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Zadanie4</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<div class="chart-container">
    <canvas id="myChart2"></canvas>
</div>
<script>
    let ctx2 = document.getElementById('myChart2').getContext('2d');
    document.getElementById("myChart2").height = 425;
    document.getElementById("myChart2").width = 425;
    let myChart2 = new Chart(ctx2, {
        type: 'horizontalBar',
        data: {
            labels: <?php echo json_encode($chart2Coutry);?>,
            datasets: [{
                label: 'Uloha4b - pocet ludi ktory boli nakazeny oproti tym co boli vylieceny, v percentach',
                data: <?php echo json_encode($chart2PercentageCured);?>,
                backgroundColor:'rgba(250, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        responsive:true,
                        maintainAspectRatio: true
                    }
                }]
            }
        }
    });
</script>
<br>
<h1><a href="index.php">Back to main page</a></h1>
</body>
</html>
