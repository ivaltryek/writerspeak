<?php

ob_start();
session_start();

function loggedin(){
    if(isset($_SESSION['givenName']) && !empty($_SESSION['givenName']) && isset($_SESSION['user'])){
        return true;
    }else{
        return false;
    }
}

function is_admin_logged_in(){
    if(isset($_SESSION['admin'])){
        return true;
    }else{
        return false;
    }
}

?>