<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


 ?>
<?php

    
    session_start();
    require_once "./googleapi/vendor/autoload.php";
    $gClient = new Google_Client();
    $gClient->setClientId("285253487357-to2sancc7o0vj39iebp59cq97vre0hdo.apps.googleusercontent.com");
    $gClient->setClientSecret("_hSrSmcWJ3TR_0sMkAS-Jk7g");
    $gClient->setApplicationName("google login demo");
    $gClient->setRedirectUri("http://localhost/writerspeak/googlelogin/g-callback.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

?>