<?php 

    require "./conn.php";
    require "./errorfunc.php";
    $password_string = "avengers";
    $options = array(
       
        'cost' => 10,
      );
      $password_hash = password_hash($password_string, PASSWORD_BCRYPT, $options);
      echo $password_hash;

?>