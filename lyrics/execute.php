<?php
require "../dbconfig/conn.php";
require "../components/session.php";

if(isset($_GET['like'])){
    $get_data_query = "select * from `lyrics`";
    $recieved_data = $conn->query($get_data_query);
    foreach($rd as $recieved_data){
        $likes = $rd['likes'];
        $dislike = $rd['dislike'];
    }
    $query = "update `lyrics` set `likes` = ?";
    $like_incr = $conn->prepare($query);
    $like_incr->execute(array($likes+1));
    header("Location:./showlyrics.php?song=".$_GET['lyric']);
}

?>