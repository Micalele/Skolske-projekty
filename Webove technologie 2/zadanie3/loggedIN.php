<?php
session_start();

include "config.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie3;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Z3</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body style="padding-top: 0">
<div>
    Prave je prihlaseny:
    <?php
    if ($_SESSION['type']=="normal"){
        $query = "SELECT * FROM `vlastnaRegistracia` WHERE login='" . $_SESSION["loggedIn"] . "'";
        $result = $conn->query($query);
        $result = $result->fetch();

        if ($_SESSION['type']=="normal") echo $result[0] . " " . $result[1] . "<br>Normal login";
        if ($_SESSION['type']=="ldap") echo $_SESSION['meno'] . "<br>Ldap login";

        $query = "SELECT * FROM `prihlasenia` WHERE login='" . $_SESSION["loggedIn"] . "'";
        $result = $conn->query($query);
        echo "<br>Posledne prihlasenia:<br>";
        echo "<table><thead><tr><th>Sposob</th><th>Cas</th></tr></thead><tbody>";
        while ($row = $result->fetch()){
            echo "<tr><td>" . $row[2] .  "</td><td>" . $row[1] . "</td></tr>";
        }
        echo "</tbody></table>";
    }
    else if ($_SESSION['type']=="ldap"){
        if ($_SESSION['type']=="normal") echo $result[0] . " " . $result[1] . "<br>Normal login";
        if ($_SESSION['type']=="ldap") echo $_SESSION['meno'] . "<br>Ldap login";
        $query = "SELECT * FROM `prihlasenia` WHERE login='" . $_SESSION["login"] . "'";
        $result = $conn->query($query);
        echo "<br>Posledne prihlasenia:<br>";
        echo "<table><thead><tr><th>Sposob</th><th>Cas</th></tr></thead><tbody>";
        while ($row = $result->fetch()){
            echo "<tr><td>" . $row[2] .  "</td><td>" . $row[1] . "</td></tr>";
        }
        echo "</tbody></table>";
    }
    else{
        header("Location: https://147.175.121.210:4543/cv3/logOut.php");
    }

    $query = "SELECT COUNT(sposob) FROM prihlasenia WHERE sposob='ldap'";
    $result = $conn->query($query);
    $result = $result->fetch()[0];
    echo "Pocet prihlaseni pomocou LDAP: " . $result . "<br>";
    $query = "SELECT COUNT(sposob) FROM prihlasenia WHERE sposob='normal'";
    $result = $conn->query($query);
    $result = $result->fetch()[0];
    echo "Pocet prihlaseni pomocou Normal: " . $result . "<br>";
    $query = "SELECT COUNT(sposob) FROM prihlasenia WHERE sposob='google'";
    $result = $conn->query($query);
    $result = $result->fetch()[0];
    echo "Pocet prihlaseni pomocou Google: " . $result . "<br>";
    ?>
</div>
    <br><a href="index.php">HOME</a>
    <br><a href="logOut.php">Log out</a>
</body>
</html>