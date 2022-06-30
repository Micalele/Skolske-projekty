<!DOCTYPE html>
<html lang="sk">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<h1>Zadanie3 - Logins</h1>
<?php
session_start();
if ($_SESSION["type"]=="google"){
    echo "Ste prihlaseny cez Gmail, ak vyberiete inu moznost ako prihlasenie pomocou gmailu budete odhlaseny.<br>";
}
?>
<a href="normalRegister.php">Normal register</a><br>
<a href="normalLogin.php">Normal login</a><br>

<a href="ldapLogin.php">Ldap login</a><br>

<a href="googleLogin.php">Google login</a>


</body>
</html>