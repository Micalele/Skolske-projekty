<?php
session_start();
if($_SESSION["type"]=="ldap" || $_SESSION["type"]=="normal"){
    header("Location: https://147.175.121.210:4543/cv3/loggedIN.php");
}
if(isset($_POST["login"]) && isset($_POST["password"])){
    $ldapuid = $_POST["login"];
    $ldappass = $_POST["password"];

    $dn  = 'ou=People, DC=stuba, DC=sk';
    $ldaprdn  = "uid=$ldapuid, $dn";

// connect to ldap server
    $ldapconn = ldap_connect("ldap.stuba.sk")
    or die("Could not connect to LDAP server.");

    if ($ldapconn) {
        $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
// binding to ldap server
        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

// verify binding
        if ($ldapbind) {
            echo "LDAP bind successful...<br>";
            $_SESSION['type'] = "ldap";
            $results=ldap_search($ldapconn,$dn,"uid=xmichalem",array("givenname","employeetype","surname","mail","faculty","cn","uisid","uid"));
            $info=ldap_get_entries($ldapconn,$results);
//var_dump($info);

            $i=0;
            while ($i <= 0) {
                echo $info[$i]['cn'][0]."cn<br>";
                echo $info[$i]['givenname'][0]."<br>";
                echo $info[$i]['sn'][0]."<br>";
                echo $info[$i]['employeetype'][0]."<br>";
                echo $info[$i]['uisid'][0]."<br>";
                echo $info[$i]['uid'][0]."<br>";
                echo $info[$i]['faculty'][0]."<br><br>";
                $i++;
            }
            include "config.php";
            try {
                $conn = new PDO("mysql:host=localhost;dbname=zadanie3;charset=utf8", USERNAME, PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . "<br>";
            }
            $query = "INSERT INTO `prihlasenia`(`login`, `cas`, `sposob`) VALUES ('" . $_POST["login"] .  "', '" . date('Y-m-d', time()).  "', 'ldap')";
            $result = $conn->query($query);

            $_SESSION["meno"] = $info[0]['cn'][0];
            $_SESSION["login"] = $_POST["login"];
            header("Location: https://147.175.121.210:4543/cv3/loggedIN.php");
        } else {
            echo "LDAP bind failed...";
        }
    }
    ldap_unbind($ldapconn);
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Z3</title>
</head>
<body>
<form action="ldapLogin.php" method="post">
    <label>Login: <input name="login" type="text"></label>
    <label>Password: <input name="password" type="password"></label>
    <input type="submit">
</form>
<br><a href="index.php">HOME</a>
</body>
</html>
