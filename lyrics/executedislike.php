<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/session.php";

if (!loggedin()) {
    echo '<script language="javascript">';
    echo 'alert("Login required to access this feature")';
    echo '</script>';
    header("refresh:1;url=../index.php");
}

if (isset($_GET['dislike'], $_GET['lyric'])) {
    $sql_if_exists = "select * from `lyric_dislike` where `lyric_name` = ? and `disliked_by` = ?";
    $sql_if_exists_prepare = $conn->prepare($sql_if_exists);
    $sql_if_exists_prepare->execute(array($_GET['lyric'], $_SESSION['user']));
    $sql_if_exists_array = $sql_if_exists_prepare->fetchAll(PDO::FETCH_ASSOC);
    //print_r($sql_if_exists_array);
    if ($sql_if_exists_prepare->rowCount() > 0) {
        echo '<script language="javascript">';
        echo 'alert("You can not dislike the post twice.!!")';
        echo '</script>';
        header("refresh:1;url=./showlyrics.php?song=" . $_GET['lyric']);
        exit();
    } else {
        $sql_dislike_inserter = "insert into `lyric_dislike`(`lyric_name`,`disliked_by`) values(?,?) ";
        $sql_dislike_inserter_prepare = $conn->prepare($sql_dislike_inserter);
        $sql_dislike_inserter_prepare->execute(array($_GET['lyric'], $_SESSION['user']));

        $sql_dislike_getter = "select `dislike`,`likes` from `lyrics` where `trimmedtitle` = ?";
        $sql_dislike_getter_prepare = $conn->prepare($sql_dislike_getter);
        $sql_dislike_getter_prepare->execute(array($_GET['lyric']));
        $sql_dislike_getter_array = $sql_dislike_getter_prepare->fetchAll(PDO::FETCH_ASSOC);
        //print_r($sql_dislike_getter_array);
        foreach ($sql_dislike_getter_array as $sd) {
            $current_dislikes = $sd['dislike'];
            $current_likes = $sd['likes'];
        }

        $sql_dislike_updater = "update `lyrics` set `dislike` = ?, `likes` = ?";
        $sql_dislike_updater_prepare = $conn->prepare($sql_dislike_updater);
        $sql_dislike_updater_prepare->execute(array($current_dislikes + 1,$current_likes-1));

        $sql_like_remover = "delete from `lyric_like` where `lyric_name` = ? and `liked_by` = ?";
        $sql_like_remover_prepare = $conn->prepare($sql_like_remover);
        $sql_like_remover_prepare->execute(array($_GET['lyric'],$_SESSION['user']));
        header("Location:./showlyrics.php?song=" . $_GET['lyric']);
        exit();

    }
}
