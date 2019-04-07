<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/banner.php";
require "../components/session.php";
require "../components/customnav.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href='https://fonts.googleapis.com/css?family=Domine:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-size: 2vw;
            font-family: 'Domine';
            color: #000;
            background-color: #FFF;

            >* {
                box-sizing: border-box;
            }
        }

        p,
        h1 {
            margin: 0;
            padding: 6vw 4vw 6vw 4vw;
            text-align: center;
        }

        h1 {
            color: #000;
            padding: 4vw 4vw 4vw 4vw;
            font-size: 3vw;
            line-height: 1;
        }

        p {
            line-height: 1.4;
            color: lighten(#FFF, 50);
        }

        div.before {
            max-width: 60%;
            margin: auto;
        }

        div.arrow {
            position: relative;
            top: 5vw;
            max-width: 60%;
            margin: auto;
            background: #b92e34;
            margin-bottom: 8vw;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        div.arrow:after,
        div.arrow:before {
            box-sizing: border-box;
            content: '';
            display: block;
            position: absolute;
            right: 0;
            top: -4.91vw;
            width: 50%;
            border: 5vw solid transparent;
            border-bottom-color: #b92e34;
            border-right: none;
            border-top: none;
        }

        div.arrow:before {
            left: 0;
            right: auto;
            border: 5vw solid transparent;
            border-bottom-color: #b92e34;
            border-left: none;
            border-top: none;
        }
    </style>
    <title>WritersPeak|Display</title>
    <!-- <link rel="stylesheet" href="../boot/css/bootstrap.min.css"> -->

</head>
<?php
if (isset($_GET['song'])) {
    $query_select = "select * from `lyrics` where `trimmedtitle` = '" . $_GET['song'] . "' ";
    $data = $conn->query($query_select);
    foreach ($data as $row) {

        $title = $row['title'];
        $author = $row['author'];
        $lyrics = $row['lyrics'];
        $title_trimmed = $row['trimmedtitle'];
        $cookie_name = "title_showlyrics";
        $cookie_value = $title_trimmed;
        $views = $row['views'];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }
}

?>

<body>
    <a name="top"></a>
    <div class="before">
        <h1>
            <i class="fas fa-music"></i> <?php echo $title; ?>
            </h2>
    </div>
    <div class="arrow">
        <p>

            <?php $lyrics_ = nl2br($lyrics);
            echo $lyrics_;
            ?>
            <br><br> <sub><i>Written By @<u><a class="text-dark"><?php echo $author ?></a></u></i></sub>
        </p>
        <?php
        // if (isset($_SESSION['last_visit']) && time() - $_SESSION['last_visit'] < 30) {
        //     echo '<script language="javascript">';
        //     echo 'alert("Wait 30 secs before you reload this page")';
        //     echo '</script>';
        // } else {
        //     $_SESSION['last_visit'] = time();
        //     $new_count = $views + 1;
        //     $query = "update `lyrics` set `views` = ?";
        //     $count_stmt = $conn->prepare($query);
        //     $count_stmt->execute(array($new_count));
        //     $view_data = $conn->query($query_select);
        // }
        $get_likes = "select * from `lyrics` where `trimmedtitle` = ?";
        $perform = $conn->prepare($get_likes);
        $perform->execute(array($_GET['song']));
        $data = $perform->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $d) {
            $total_likes = $d['likes'];
            $total_dislikes = $d['dislike'];
        }
        ?>
        <span class="glyphicon glyphicon-chevron-up"></span>
        <u><a class="text-dark" href="#top" style="padding-left:20px"><i class="fas fa-arrow-circle-up"></i></i></a></b></u>
        <u><a style="padding-left:210px" class="text-dark" href="../userops/reportlyric.php?report=<?php echo $_GET['song']; ?>"><i class="fas fa-flag"></i> Report Lyrics</a></u>
        <u><a style="padding-left:150px" class="text-dark" href="../comment/comment.php"><i class="fas fa-comments"></i> Comment</a></u><br>
        <span style="font-size:18px; padding-left:20px"><i class="far fa-eye"></i> <?php echo $views ?></span>
        <?php
        $url = "execute.php?like=like&lyric=" . $_GET['song'];
        echo '<a href = "' . $url . '" style="padding-left:25px;padding-top:40px">
                 <i class="fas fa-thumbs-up"></i></a>'; ?>&nbsp;<span text="text-dark"><?php
                 if($total_likes < 0){
                    echo '0';}else{echo $total_likes;}
                 ?></span>
        <?php
        $url2 = "executedislike.php?dislike=dislike&lyric=" . $_GET['song'];
        echo '<a href = "' . $url2 . '" style="padding-left:25px;padding-top:40px">
                 <i class="fas fa-thumbs-down"></i></a>'; ?>&nbsp;<span text="text-dark"><?php
                 if($total_dislikes < 0){
                     echo '0';
                 }else{
                     echo $total_dislikes;
                 }
                 ?></span>


    </div>
    <br>
</body>

</html>