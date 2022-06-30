<?php
if(isset($_POST["meno"]) && isset($_POST["priezvisko"]) && isset($_POST["email"]) && isset($_POST["login"]) && isset($_POST["password"])){
    if ($_POST["meno"] != "" && $_POST["priezvisko"] != "" && $_POST["email"] != "" && $_POST["login"] != "" && $_POST["password"] != ""){
        include "config.php";
        try {
            $conn = new PDO("mysql:host=localhost;dbname=zadanie3;charset=utf8", USERNAME, PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }

        $query = "SELECT COUNT(email) FROM `vlastnaRegistracia` WHERE email='" . $_POST["email"] . "'";
        $result = $conn->query($query);
        $mailCount = $result->fetch()[0];

        $query = "SELECT COUNT(login) FROM `vlastnaRegistracia` WHERE login='" . $_POST["login"] . "'";
        $result = $conn->query($query);
        $loginCount = $result->fetch()[0];

        if ($mailCount=="0" && $loginCount=="0"){
            $query = "INSERT INTO `vlastnaRegistracia` (`meno`, `priezvisko`, `email`, `login`, `heslo`) VALUES ('" . $_POST["meno"] .  "', '" . $_POST["priezvisko"] .  "', '" . $_POST["email"] .  "', '" . $_POST["login"] .  "', '" . password_hash($_POST["password"], PASSWORD_DEFAULT) .  "');";
            $result = $conn->query($query);
            header("Location: https://147.175.121.210:4543/cv3/mail.php");
        }
        else {
            echo "Login alebo email uz je tu zaregistrovany";
        }
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
<h1>Zadanie3 - Normalna registracia</h1>
<form action="normalRegister.php" method="post">
    <label>Meno: <input name="meno" type="text"></label><br>
    <label>Priezvisko: <input name="priezvisko" type="text"></label><br>
    <label>Email: <input name="email" type="text"></label><br>
    <label>Login: <input name="login" type="text"></label><br>
    <label>Password: <input name="password" type="password"></label><br>
    <input type="submit">
</form>
<br><a href="index.php">HOME</a>
</body>
</html>
