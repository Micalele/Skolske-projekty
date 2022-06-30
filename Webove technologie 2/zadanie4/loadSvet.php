<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Zadanie4</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body id="top10perc">
<div class="ramcek">
    <?php
    include "conf.php";
    try {
        $conn = new PDO("mysql:host=localhost;dbname=zadanie4;charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "<br>";
    }

    $query = "SELECT COUNT(*) FROM `svet`";
    $result = $conn->query($query)->fetch();

    if ($result[0] == "0"){
        $url = "https://www.worldometers.info/world-population/population-by-country/";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_VERBOSE,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,15);

        $curl = curl_exec($ch);
        if (!empty($curl)){
            $page = new DOMDocument();
            $page->loadHTML($curl);
            $tabulka = $page->getElementById("example2");
            $rows = $tabulka->getElementsByTagName("tr");
            $skipFirst = 0;


            foreach ($rows as $row){
                if ($skipFirst == 1) {
                    $country = str_replace("'", "''", $row->getElementsByTagName("td")[1]->nodeValue);
                    $population = str_replace(",", "", $row->getElementsByTagName("td")[2]->nodeValue);
                    $query = "INSERT INTO `svet`(`country`, `population`) VALUES ('" . $country ."','" . $population ."')";
                    $result = $conn->query($query);
                }
                else $skipFirst = 1;
            }
        }
        echo "<br>Data nacitane uspesne<br><br> <a href='mail.php'>>Click here to return to main page<</a>";
    }
    else echo "<br>Data su uz nacitane<br><br> <a href='mail.php'>>Click here to return to main page<</a>";
    ?>
</div>
</body>
</html>