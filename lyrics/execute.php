<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/session.php";

if (isset($_GET['like'])) {
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
        $update_query = "update `lyrics` set `likes` = ?";
        $update_like = $conn->prepare($update_query);
        $update_like->execute(array($current_likes + 1));
        //$update_like->bindParam(':likes',)
        header("Location:./showlyrics.php?song=" . $_GET['lyric']);
    }
    //header("Location:./showlyrics.php?song=".$_GET['lyric']);
    if (isset($_GET['dislike'])) {

        $get_dislike_query = "select * from `lyric_dislike` where `lyric_name` = :lyricname and `disliked_by` = :likedby";
        $dislike_data = $conn->prepare($get_dislike_query);
        // print_r($_SESSION);
        $dislike_data->bindParam(':lyricname', $_GET['lyric']);
        $dislike_data->bindParam(':likedby', $_SESSION['user']);
        $dislike_data->execute();
        echo 'hi';
        if ($dislike_data->rowCount() > 0) {
            echo '<script language="javascript">';
            echo 'alert("You can not dislike the post twice.!!")';
            echo '</script>';
            header("refresh:1;url=./showlyrics.php?song=" . $_GET['lyric']);
            exit();
        } else {
            $distable = "insert into `lyric_dislike` (`lyric_name`,`disliked_by`) values(:lyricname,:likedby)";
            $dislike_incr = $conn->prepare($distable);
            // print_r($_SESSION);
            $dislike_incr->bindParam(':lyricname', $_GET['lyric']);
            $dislike_incr->bindParam(':likedby', $_SESSION['user']);
            $dislike_incr->execute();

            $get_likes_query = "select * from `lyrics` where `trimmedtitle` = ? ";
            $exec = $conn->prepare($get_likes_query);
            $exec->execute(array($_GET['lyric']));
            $data = $exec->fetchAll(PDO::FETCH_ASSOC);
            //print_r($data);
            foreach ($data as $d) {
                $current_likes =  $d['likes'];
                $current_dislikes = $d['dislike'];
            }


            $dislike_query = "update `lyrics` set `dislike` = ?,`likes` = ?";
            $de = $conn->prepare($dislike_query);
            $de->execute(array($current_dislikes + 1,$current_likes-1));
            header("Location:./showlyrics.php?song=".$_GET['lyric']);

        }
    }
}
