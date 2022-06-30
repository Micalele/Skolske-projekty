<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css.css">
    <script src="showTables.js"></script>
    <script src="sort.js"></script>
    <title>Z2</title>
</head>
<body>
        <?php
        echo "<header>";
        include "conf.php";
        include_once "stranyU4.php";
        try {
            $conn = new PDO("mysql:host=localhost;dbname=cvicenie3;charset=utf8", USERNAME, PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Zadanie2 úloha 3 - Connection succesfully<br>";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }
        echo "<br><a id='uloha' href='mail.php'>ULOHA Č.3</a>";
        echo "</header>";

        echo "<label>Vyberte volebne obdobie</label>
<select onchange='showTables()' id=\"listbox\">
   <option selected value='1'>1</option>
   <option value='2'>2</option>
   <option value='3'>3</option>
   <option value='4'>4</option>
   <option value='5'>5</option>
   <option value='6'>6</option>
   <option value='7'>7</option>
   <option value='8'>8</option>
   <option value='9'>9</option>
   <option value='10'>10</option>
</select>";

        $query = "SELECT vysledky.id_volby, strany.nazov, strany.skratka, vysledky.kresla, vysledky.koalicia FROM vysledky, strany WHERE vysledky.id_strany = strany.id";
        $result = $conn->query($query);
        $poleStran = [];
        while($row = $result->fetch()) {
            $strana = new stranyU4($row["nazov"], $row["skratka"], $row["kresla"], $row["koalicia"], $row["id_volby"]);
            array_push($poleStran, $strana);
        }

        $query = "SELECT id_volby, datumOD, datumDO FROM vlady";
        $result = $conn->query($query);
        $poleVlad = [];
        while($row = $result->fetch()) {
            $vlada = [];
            array_push($vlada, $row["id_volby"]);
            array_push($vlada, $row["datumOD"]);
            array_push($vlada, $row["datumDO"]);
            array_push($poleVlad, $vlada);
        }

        echo "<div id='1'><table class='myTable'><thead><tr>
                         <th onclick='sortU4(0, 0)'>Volby</th>
                         <th onclick='sortU4(1, 0)'>Skratka</th>
                         <th onclick='sortU4(2, 0)'>Nazov</th>
                         <th onclick='sortU4(3, 0)'>Kresla</th>
                    </tr></thead><tbody>";

        $tabulka = 2;
        $pc2 = 0;
        $kreslaKoalicia = 0;
        $kreslaOpozicia = 0;

        for ($pc = 0; $pc < sizeof($poleStran); $pc++){
            $volby = $poleStran[$pc]->getVolby();
            $skratka = $poleStran[$pc]->getSkratka();
            $nazov = $poleStran[$pc]->getNazovStrany();
            $kresla = $poleStran[$pc]->getZiskaneKresla();
            $koalicia = $poleStran[$pc]->getKoalicia();
            if ($volby == "" . $tabulka){
                $pc2++;
                echo "</tbody></table>";

                echo "<table class='myTable'><thead><tr><th>Číslovanie</th><th>Vláda zložená</th><th>Vláda rozložená</th></tr></thead><tbody>";
                $tmp = 1;
                for ($i = 0; $i < sizeof($poleVlad); $i++){
                    if ($poleVlad[$i][0] == $volby-1){
                        echo "<tr><td>" . $tmp . "</td><td>" . $poleVlad[$i][1] . "</td><td>" . $poleVlad[$i][2] . "</td></tr>";
                        $tmp++;
                    }
                }
                echo "</tbody></table>";

                echo "<p>Pocet kresiel pre Koaliciu: $kreslaKoalicia<br>Pocet kresiel pre Opoziciu: $kreslaOpozicia<br></p></div>";
                $kreslaOpozicia = 0;
                $kreslaKoalicia = 0;
                echo "<div id='$tabulka' style='display: none'><table class='myTable'><thead><tr>
                         <th onclick='sortU4(0, "; echo $pc2 ; echo ")'>Volby</th>
                         <th onclick='sortU4(1, "; echo $pc2 ; echo ")'>Skratka</th>
                         <th onclick='sortU4(2, "; echo $pc2 ; echo ")'>Nazov</th>
                         <th onclick='sortU4(3, "; echo $pc2 ; echo ")'>Kresla</th>
                    </tr></thead><tbody>";
                         $tabulka++;
            }
            if ($koalicia == "1") $kreslaKoalicia = $kreslaKoalicia + intval($kresla);
            else $kreslaOpozicia = $kreslaOpozicia + intval($kresla);
            if ($koalicia == "1") echo "<tr class='row$pc2' style='background-color: #370000'><td>$volby</td><td>$skratka</td><td>$nazov</td><td>$kresla</td></tr>";
            else echo "<tr class='row$pc2' style='background-color: #003700'><td>$volby</td><td>$skratka</td><td>$nazov</td><td>$kresla</td></tr>";
        }
        echo "</tbody></table>";
        echo "<p>Pocet kresiel pre Koaliciu: $kreslaKoalicia<br>Pocet kresiel pre Opoziciu: $kreslaOpozicia<br></p></div>";
        ?>
</body>
</html>