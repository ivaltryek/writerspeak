<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/banner.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Domine:400' rel='stylesheet' type='text/css'>
    <style>
        body {
            padding: 0;
            margin: 0;
            font-size: 2vw;
            font-family: 'Domine';
            color: #323D40;
            background-color: #148AB2;
            > * {
                box-sizing: border-box;
            }
            }
            p, h1 {
            margin: 0;
            padding: 6vw 4vw 6vw 4vw;
            text-align:center;
            }
            h1 {
            color: #FFF458;
            padding: 4vw 4vw 4vw 4vw;
            font-size: 3vw;
            line-height: 1;
            }
            p {
            line-height: 1.4;
            color: lighten(#0D9CCC,50);
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
            background: #0D9CCC;
            margin-bottom: 8vw;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }

            div.arrow:after, div.arrow:before {
            box-sizing: border-box;
            content: '';
            display: block;
            position: absolute;
            right: 0;
            top: -4.91vw;
            width: 50%;
            border: 5vw solid transparent;
            border-bottom-color: #0D9CCC;
            border-right: none;
            border-top: none;
            }

            div.arrow:before {
            left: 0;
            right: auto;
            border: 5vw solid transparent;
            border-bottom-color: #0D9CCC;
            border-left: none;
            border-top: none;
            }

    </style>
    <title>WritersPeak|Display</title>
    <!-- <link rel="stylesheet" href="../boot/css/bootstrap.min.css"> -->

</head>
<?php
if (isset($_GET['song'])) {
    $query_select = "select * from `lyrics` where `trimmedtitle` = '".$_GET['song']."' ";
    $data = $conn->query($query_select);
    foreach($data as $row){

        $title = $row['title'];
        $author = $row['author'];
        $lyrics = $row['lyrics'];
        $title_trimmed = $row['trimmedtitle'];
        $cookie_name = "title_showlyrics";
        $cookie_value = $title_trimmed;
        setcookie($cookie_name,$cookie_value,time() + (86400 * 30), "/");
    }
}

?>
<body>
        <a name="top"></a>
        <div class="before">
        <h1>
        <?php echo $title;?>
        </h2>
        </div>
        <div class="arrow">
        <p>

        <?php $lyrics_ = nl2br($lyrics);
        echo $lyrics_;
        ?>
        <br><br>  <sub><i>Written By @<u><a class = "text-dark"><?php echo $author ?></a></u></i></sub>
        </p>
        <span class="glyphicon glyphicon-chevron-up"></span>
        <u><a class="text-danger" href="#top">Back to top?</a></b></u>
        <u><a style="padding-left:150px" class="text-dark" href="../userops/reportlyric.php?report=<?php echo $_GET['song']; ?>">Report Lyric</a></u>
        <u><a style="padding-left:150px" class="text-dark" href="../comment/comment.php">Comment</a></u>
        </div>
        <br>
</body>
</html>
