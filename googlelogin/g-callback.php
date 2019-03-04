<?php

    require_once "./config.php";

    if(isset($_SESSION['access_token'])){
        $gClient->setAccessToken($_SESSION['access_token']);
    }

    else if(isset($_GET['code'])){
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    }else{
        header("Location:login.php");
        exit();
    }



    $oAuth = new Google_Service_Oauth2($gClient);
    $userdata = $oAuth->userinfo_v2_me->get();

   // echo "<pre>";
    //var_dump($userdata);
    $_SESSION['id'] = $userdata['id'];

    $_SESSION['email'] = $userdata['email'];
    $_SESSION['gender'] = $userdata['gender'];
    $_SESSION['picture'] = $userdata['picture'];
    $_SESSION['familyName'] = $userdata['familyName'];
    $_SESSION['givenName'] = $userdata['givenName'];

    header("Location:showdata.php");
    exit();
?>