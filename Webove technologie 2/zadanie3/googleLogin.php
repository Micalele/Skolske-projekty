<?php
//mail.php

//Include Configuration File
include('googleAuth.php');

//$login_button = '';

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
    //It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if(!isset($token['error']))
    {
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];

        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);

        //Get user profile data from google
        $data = $google_service->userinfo->get();

        //Below you can find Get profile data and store into $_SESSION variable
        if(!empty($data['given_name']))
        {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name']))
        {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email']))
        {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($data['gender']))
        {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if(!empty($data['picture']))
        {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
    //Create a URL to obtain user authorization
    $login_button = '<a href="'.$google_client->createAuthUrl().'">Log in</a>';
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
    <link rel="stylesheet" type="text/css" href="css.css">

</head>
<body style="padding-top: 0">
<div class="container">
    <br />
    <h2 align="center">PHP Login using Google Account</h2>
    <br />
    <div class="panel panel-default">
        <?php
        if($login_button == '')
        {
            $_SESSION['type'] = "google";
            echo "Prave je prihlaseny:" . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . "<br>";
            include "config.php";
            try {
                $conn = new PDO("mysql:host=localhost;dbname=zadanie3;charset=utf8", USERNAME, PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . "<br>";
            }
            $query = "INSERT INTO `prihlasenia`(`login`, `cas`, `sposob`) VALUES ('" . $_SESSION['user_email_address'] .  "', '" . date('Y-m-d', time()).  "', 'google')";
            $result = $conn->query($query);

            $query = "SELECT * FROM `prihlasenia` WHERE login='" . $_SESSION['user_email_address'] . "'";
            $result = $conn->query($query);
            echo "<br>Posledne prihlasenia:<br>";
            echo "<table><thead><tr><th>Sposob</th><th>Cas</th></tr></thead><tbody>";
            while ($row = $result->fetch()){
                echo "<tr><td>" . $row[2] .  "</td><td>" . $row[1] . "</td></tr>";
            }
            echo "</tbody></table>";
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
            echo "<br><a href=\"mail.php\">HOME</a><br>";
            echo '<a href="googleLogout.php">Logout</a>';
        }
        else
        {
            echo '<div align="center">'.$login_button;
            echo "<br><a href=\"mail.php\">HOME</a><br>" . '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>