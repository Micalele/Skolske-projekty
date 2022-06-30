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
    $query = "SELECT COUNT(*) FROM `korona`";
    $result = $conn->query($query)->fetch();

    if ($result[0] == "0"){
        $startDate = strtotime("2020-01-22");
//$startDate = strtotime("2020-03-21");
        while($startDate != strtotime("2020-03-22")){
            date('m-d-Y', $startDate);
            $url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/" . date('m-d-Y', $startDate) . ".csv";
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_VERBOSE,true);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,15);

            $curl = curl_exec($ch);
            $table = array();
            if (!curl_errno($ch)){
                $output = array_filter(explode(PHP_EOL, $curl));
                foreach ($output as $item){
                    $item = str_getcsv($item);
                    if ($item[3] == ""){
                        $item[3] = "0";
                    }
                    if ($item[4] == ""){
                        $item[4] = "0";
                    }
                    if ($item[5] == ""){
                        $item[5] = "0";
                    }

                    switch ($item[1]){
                        case "Congo (Brazzaville)":
                            $item[1]="Congo";
                            break;
                        case"Ivory Coast":
                        case"Cote d'Ivoire":
                            $item[1]="Côte d'Ivoire";
                            break;
                        case "Republic of Ireland":
                        case"North Ireland":
                            $item[1]="Ireland";
                            break;
                        case" Azerbaijan":
                            $item[1]="Azerbaijan";
                            break;
                        case "Congo (Kinshasa)":
                        case"Republic of the Congo":
                            $item[1]="DR Congo";
                            break;
                        case "Czechia":
                        case "Czech Republic":
                            $item[1]="Czech Republic (Czechia)";
                            break;

                        case "Iran (Islamic Republic of)":
                            $item[1]="Iran";
                            break;
                        case "Republic of Korea":
                        case "Korea, South":
                            $item[1]="South Korea";
                            break;
                        case "Macau":
                        case "Macao SAR":
                            $item[1]="Macao";
                            break;
                        case"Vatican City":
                            $item[1]="Holy See";
                            break;
                        case "Hong Kong SAR":
                        case "Mainland China":
                            $item[1]="China";
                            break;
                        case "Others":
                            $item[1]="Cruise Ship";
                            break;
                        case "Taipei and environs":
                        case "Taiwan*":
                            $item[1]="Taiwan";
                            break;
                        case "Guernsey":
                        case "UK":
                            $item[1]="United Kingdom";
                            break;
                        case "Jersey":
                        case "US":
                            $item[1]="United States";
                            break;
                        case "Viet Nam":
                            $item[1]="Vietnam";
                            break;
                        case "Russian Federation":
                            $item[1]="Russia";
                            break;
                        case "Republic of Moldova":
                            $item[1]="Moldova";
                            break;
                        case "The Bahamas":
                        case "\"Bahamas":
                        case "Bahamas, The":
                            $item[1]="Bahamas";
                            break;
                        case "Faroe Islands":
                            $item[1]="Denmark";
                            break;
                        case "occupied Palestinian territory":
                        case "State of Palestine":
                        case "Palestine":
                            $item[1]="Israel";
                            break;
                        case "St. Martin":
                            $item[1]="France";
                            break;
                        case "Kosovo":
                            $item[1]="Serbia";
                            break;

                        case "Saint Vincent and the Grenadines":
                            $item[1]="St. Vincent & Grenadines";
                            break;
                        case "Gambia, The":
                        case "\"Gambia":
                        case "The Gambia":
                            $item[1]="Gambia";
                            break;

                        case "Cape Verde":
                            $item[1]="Cabo Verde";
                            break;
                        case "East Timor":
                            $item[1]="Timor-Leste";
                            break;
                    }
                    $item[0] = str_replace("'", "''", $item[0]);
                    $item[1] = str_replace("'", "''", $item[1]);
                    array_push($table, $item);
                }
                array_shift($table);

                foreach ($table as $item){
                    $query = "INSERT INTO `korona`(`state`, `country`, `update`, `confirmed`, `dead`, `recovered`) VALUES ('" . $item[0] ."', '" . $item[1] ."', '" . date('Y-m-d', strtotime($item[2])) . "', '" . $item[3] ."', '" . $item[4] ."', '" . $item[5] ."')";
                    $result = $conn->query($query);
                }

                $startDate = $startDate + 86400;
            }
        }
        echo "<br>Data nacitane uspesne<br><br> <a href='mail.php'>>Click here to return to main page<</a>";
    }
    else echo "<br>Data su uz nacitane<br><br> <a href='mail.php'>>Click here to return to main page<</a>";
    ?>
</div>
</body>
</html>