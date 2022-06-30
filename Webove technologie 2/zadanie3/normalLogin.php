<?php
session_start();
if($_SESSION["type"]=="ldap" || $_SESSION["type"]=="normal"){
    header("Location: https://147.175.121.210:4543/cv3/loggedIN.php");
}
if(isset($_POST["login"]) && isset($_POST["password"])){
    include "config.php";
    try {
        $conn = new PDO("mysql:host=localhost;dbname=zadanie3;charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "<br>";
    }

    $query = "SELECT heslo FROM `vlastnaRegistracia` WHERE login='" . $_POST["login"] . "'";
    $result = $conn->query($query);
    $password = $result->fetch()[0];
    if (password_verify($_POST["password"], $password)){
        $query = "INSERT INTO `prihlasenia`(`login`, `cas`, `sposob`) VALUES ('" . $_POST["login"] .  "', '" . date('Y-m-d', time()).  "', 'normal')";
        $result = $conn->query($query);
        $_SESSION["type"] = "normal";
        $_SESSION["loggedIn"] = $_POST["login"];
        header("Location: https://147.175.121.210:4543/cv3/loggedIN.php");
    }

}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Z3</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
    <h1>Zadanie 3 - Normalne prihlasenie</h1>
    <form action="normalLogin.php" method="post">
        <label>Login: <input name="login" type="text"></label>
        <label>Password: <input name="password" type="password"></label>
        <input type="submit">
    </form>
    <br><a href="index.php">HOME</a>
</body>
</html>
