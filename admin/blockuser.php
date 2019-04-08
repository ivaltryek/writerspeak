<?php

require "../dbconfig/conn.php";
require "../components/session.php";
require "../components/errorfunc.php";

if (!is_admin_logged_in()){
    header("Location:../index.php");
}

if(isset($_GET['user'])){
    $block_sql = "update `googleloginusers` set `is_blocked` = ? where `username` = ?";
    $block_sql_ = $conn->prepare($block_sql);
    if($block_sql_->execute(array(1,$_GET['user']))){
        header("Location:./getreports.php");
    }else{
        echo 'FAILED';
    }
}

?>