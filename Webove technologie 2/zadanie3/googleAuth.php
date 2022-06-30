<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('498093700653-3a3k3lha69h6o0u27blg2v2ka2so2lie.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('5r14PzpUY73UtRrJ5Zin1xTA');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://wt143.fei.stuba.sk:4543/cv3/googleLogin.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>