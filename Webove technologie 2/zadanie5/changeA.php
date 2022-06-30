<?php
if ($_GET["konstanta"]){
    include "conf.php";
    try {
        $conn = new PDO("mysql:host=localhost;dbname=zadanie5;charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "<br>";
    }
    $query = "DELETE FROM `konstanta`";
    $result = $conn->query($query);
    $query = "INSERT INTO `konstanta`(`a`) VALUES (" . $_GET["konstanta"] . ")";
    $result = $conn->query($query);
}