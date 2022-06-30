<?php
session_start();
$_SESSION["type"] = "";
$_SESSION["loggedIn"] = "";
session_destroy();
header("Location: https://147.175.121.210:4543/cv3/mail.php");
