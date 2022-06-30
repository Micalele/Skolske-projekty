<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css.css">
    <script src="filter.js"></script>
    <script src="sort.js"></script>
    <title>Z2</title>
</head>
<body>
        <?php
        echo "<header>";
        include "conf.php";
        include_once "osobaU3.php";
        try {
            $conn = new PDO("mysql:host=localhost;dbname=cvicenie3;charset=utf8", USERNAME, PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Zadanie2 úloha 3 - Connection succesfully<br>";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }
        echo "<br><a id='uloha' href='uloha4.php'>ULOHA Č.4</a>";
        echo "</header>";

        $query = "SELECT meno, nazov, datumOD, datumDO FROM osoby, utvary WHERE osoby.id_utvary = utvary.id and 
                    (utvary.nazov = \"Ministerstvo vnútra\" or utvary.nazov = \"Ministerstvo vnútra a životného prostredia\"
                     or utvary.nazov = \"Ministerstvo školstva\" or utvary.nazov = \"Ministerstvo školstva a vedy\" or utvary.nazov = \"Ministerstvo školstva, mládeže a športu\" or utvary.nazov = \"Ministerstvo školstva, mládeže a telesnej výchovy\" or utvary.nazov = \"Ministerstvo školstva, vedy, mládeže a športu\"
                     or utvary.nazov = \"Ministerstvo zdravotníctva\" or utvary.nazov = \"Ministerstvo zdravotníctva a sociálnych vecí\"
                     or utvary.nazov = \"Ministerstvo financií\" or utvary.nazov = \"Ministerstvo financií, cien a miezd\"
                     or utvary.nazov = \"Ministerstvo dopravy\" or utvary.nazov = \"Ministerstvo dopravy a spojov\" or utvary.nazov = \"Ministerstvo dopravy, pôšt a telekomunikácií\" or utvary.nazov = \"Ministerstvo dopravy, spojov a verejných prác\" or utvary.nazov = \"Ministerstvo dopravy, výstavby a regionálneho rozvoja\")";
        $result = $conn->query($query);
        $poleOsob = [];
        while($row = $result->fetch()) {
            $osoba = new osobaU3($row["nazov"], $row["meno"], $row["datumOD"], $row["datumDO"]);
            array_push($poleOsob, $osoba);
        }
        echo "<div id='filter'>";
        echo "Filter: ";
        echo "<input type='radio' name='filter' id='all' value='all' checked><label for='all'>All</label>";
        echo "<input type='radio' name='filter' id='doprava' value='doprava'><label for='doprava'>Doprava</label>";
        echo "<input type='radio' name='filter' id='financie' value='financie'><label for='financie'>Financie</label>";
        echo "<input type='radio' name='filter' id='skolstvo' value='skolstvo'><label for='skolstvo'>Školstvo</label>";
        echo "<input type='radio' name='filter' id='vnutro' value='vnutro'><label for='vnutro'>Vnútro</label>";
        echo "<button onclick='filter()' id='filterButton'>Filter</button><br></div>";
        echo "<table class='myTable'><thead><tr><th onclick='sortU3(0)'>Oblasť</th>
                         <th onclick='sortU3(1)'>Ministerstvo</th>
                         <th onclick='sortU3(2)'>Meno ministra</th>
                         <th onclick='sortU3(3)'>Vo funkcii od (R.M.D)</th>
                         <th onclick='sortU3(4)'>Vo funkcii do (R.M.D)</th>
                         <th onclick='sortU3(5)'>Pocet dni vo funkcii</th>
               </tr></thead><tbody>";

        for ($pc = 0; $pc < sizeof($poleOsob); $pc++){
            $oblast = $poleOsob[$pc]->getOblast();
            $ministerstvo = $poleOsob[$pc]->getMinisterstvo();
            $meno = $poleOsob[$pc]->getMeno();
            $od = date("Y m. d.", $poleOsob[$pc]->getOd());
            if ($poleOsob[$pc]->getDo() == "-") $do = "-";
            else $do = date("Y m. d.", $poleOsob[$pc]->getDo());
            $pocetDni = $poleOsob[$pc]->getPocetDni();

            echo "<tr class='$oblast row'><td>$oblast</td><td>$ministerstvo</td><td>$meno</td><td>$od</td><td>$do</td><td>$pocetDni</td></tr>";
        }
        echo "</tbody></table>"
        ?>
</body>
</html>