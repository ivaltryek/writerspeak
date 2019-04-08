<?php
require "../components/session.php";
session_unset();
if(session_destroy()){
    header("Location:../googlelogin/login.php");
}
?>