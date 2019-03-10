<?php

require "../components/banner.php";
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/customnav.php";
require "../components/session.php";

    if(!loggedin()){
        header("Location:../index.php");
        exit();
    }
    $sql = "select * from `googleloginusers` where `username` = '".$_SESSION['user']."' ";
    $data = $conn->query($sql);
    foreach($data as $d){
        if($d['master_password'] == '' || $d['master_password'] == null){
            header("Location:./setupmaster.php");
            exit();
        }else{
            header("Location:./deactivate.php");
            exit();
        }
    }
?>
