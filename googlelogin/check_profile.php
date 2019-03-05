<?php

    include '../dbconfig/conn.php';
    if(isset($_POST['username']) == true){
        $username = $_POST['username'];
        echo $username;
        $check = $conn->query("select `username` from `googleloginusers` where `username` = '$username' ");
        $data = $check->fetchAll(PDO::FETCH_ASSOC);
        if($username == NULL){
            echo 'Choose a username';
        }else{
            if($check->rowCount()>0){
                echo "<span class='status-not-available'> ,Username is already taken.!</span>";
            }else{
                echo "<span class='status-not-available'> ,Username is Available.</span>";
            }
        }
    }

?>