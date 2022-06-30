<?php
include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie4;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}

//NACITAVANIE DAT PRE PRVY CHART
$chart1Coutry = array();
$chart1Confirmed = array();
$querySvet = "SELECT * FROM `svet`";
$resultSvet = $conn->query($querySvet);
while($rowSvet = $resultSvet->fetch()){
    //echo $rowSvet[0] . $rowSvet[1] . "<br>";
    $rowSvet[0] = str_replace("'", "''", $rowSvet[0]);
    $query = "SELECT * FROM `korona` WHERE `update` LIKE '2020-03-21' AND `country`='" . $rowSvet[0] . "'";
    $result = $conn->query($query);
    $confirmed = 0;
    while($row = $result->fetch()){
        $confirmed = $confirmed + (int)$row[3];
    }
    //echo "-" . $rowSvet[0] . "<br>-" . $confirmed . "<br>";
    if ($confirmed>0){
        array_push($chart1Coutry, $rowSvet[0]);
        if (round($confirmed*100000/(int)$rowSvet[1])>1) array_push($chart1Confirmed, round($confirmed*100000/(int)$rowSvet[1]));
        else array_push($chart1Confirmed, $confirmed*100000/(int)$rowSvet[1]);
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
    <canvas id="myChart1"></canvas>
</div>
<script>
    let ctx1 = document.getElementById('myChart1').getContext('2d');
    document.getElementById("myChart1").height = 425;
    document.getElementById("myChart1").width = 425;
    let myChart1 = new Chart(ctx1, {
        type: 'horizontalBar',
        data: {
            labels: <?php echo json_encode($chart1Coutry);?>,
            datasets: [{
                label: 'Uloha4a - potvrdene pripady na 100 000 ludi za posledny nacitany den',
                data: <?php echo json_encode($chart1Confirmed);?>,
                backgroundColor:'rgba(250, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: 'black'
                }
            },
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
