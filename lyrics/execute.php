<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/session.php";

if(!loggedin()){
    echo '<script language="javascript">';
    echo 'alert("Login required to access this feature")';
    echo '</script>';
    header("refresh:1;url=../index.php");
    exit();
}

if (isset($_GET['like'], $_GET['lyric'])) {
    //$get_data_query = "select * from `lyric_like` where `lyric_name` = ? and
    // liked_by = ?;
    $get_query = "select * from `lyric_like` where `lyric_name` = :lyricname and `liked_by` = :likedby";

    $recieved_data = $conn->prepare($get_query);
    $recieved_data->bindParam(':lyricname', $_GET['lyric']);
    $recieved_data->bindParam(':likedby', $_SESSION['user']);
    $recieved_data->execute();
    if ($recieved_data->rowCount() > 0) {
        echo '<script language="javascript">';
        echo 'alert("You can not like the post twice.!!")';
        echo '</script>';
        header("refresh:1;url=./showlyrics.php?song=" . $_GET['lyric']);
        exit();
    } else {

        $query = "insert into `lyric_like` (`lyric_name`,`liked_by`) values(:lyricname,:likedby)";
        $like_incr = $conn->prepare($query);
        // print_r($_SESSION);
        $like_incr->bindParam(':lyricname', $_GET['lyric']);
        $like_incr->bindParam(':likedby', $_SESSION['user']);
        $like_incr->execute();

        $get_likes_query = "select * from `lyrics` where `trimmedtitle` = ? ";
        $exec = $conn->prepare($get_likes_query);
        $exec->execute(array($_GET['lyric']));
        $data = $exec->fetchAll(PDO::FETCH_ASSOC);
        //print_r($data);
        foreach ($data as $d) {
            $current_likes =  $d['likes'];
            $current_dislikes = $d['dislike'];
        }
        $update_query = "update `lyrics` set `likes` = ? ,`dislike` = ?";
        $update_like = $conn->prepare($update_query);
        $update_like->execute(array($current_likes + 1,$current_dislikes-1));
        //$update_like->bindParam(':likes',)

        $sql_dislike_remover = "delete from `lyric_dislike` where `lyric_name` = ? and `disliked_by` = ?";
        $sql_dislike_remover_prepare = $conn->prepare($sql_dislike_remover);
        $sql_dislike_remover_prepare->execute(array($_GET['lyric'],$_SESSION['user']));

        header("Location:./showlyrics.php?song=" . $_GET['lyric']);
        exit();
    }
    //header("Location:./showlyrics.php?song=".$_GET['lyric']);
}
