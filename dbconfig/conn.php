<?php 

$servername = "localhost";
$username = "mj";
$password = "joker";

try { 
    $conn = new PDO("mysql:host=$servername;dbname=writerspeak", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo 'connected';
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

?>