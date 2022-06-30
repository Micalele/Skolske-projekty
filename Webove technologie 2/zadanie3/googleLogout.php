<?php

//logout.php

include('googleAuth.php');

//Reset OAuth access token
$google_client->revokeToken();

//Destroy entire session data.
session_destroy();

//redirect page to mail.php
header('location:mail.php');

?>
