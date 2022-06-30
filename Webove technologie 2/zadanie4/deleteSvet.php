<?php
include "conf.php";
try {
    $conn = new PDO("mysql:host=localhost;dbname=zadanie4;charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}

$query = "DELETE FROM `svet`";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Zadanie4</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body id="top10perc">
<div class="ramcek">
    <?php echo "Data z databazy Svetova populacia uspene vymazane<br><br> <a href='mail.php'>>Click here to return to main page<</a>"; ?>
</div>
</body>
</html>