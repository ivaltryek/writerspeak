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

?>