<?php


    function getContent(){
        require "../dbconfig/conn.php";
        require "../components/errorfunc.php";

        $query = "select * from `demo`";
        $sql = $conn->prepare($query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    $data = getContent();
    foreach($data as $d){
        echo '<img src = "' .$d['path'].'" alt = "error">';
    }
?>