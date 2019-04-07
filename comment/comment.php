
<?php
//require "../components/banner.php";
require "../components/session.php";
require "../dbconfig/conn.php";
require "../components/errorfunc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WritersPeak|Comments</title>
    <style>
        @import url(//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css);

        .detailBox {
            width:320px;
            border:1px solid #bbb;
            margin:50px;
        }
        .titleBox {
            background-color:#fdfdfd;
            padding:10px;
        }
        .titleBox label{
        color:#444;
        margin:0;
        display:inline-block;
        }

        .commentBox {
            padding:10px;
            border-top:1px dotted #bbb;
        }
        .commentBox .form-group:first-child, .actionBox .form-group:first-child {
            width:80%;
        }
        .commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
            width:18%;
        }
        .actionBox .form-group * {
            width:100%;
        }
        .taskDescription {
            margin-top:10px 0;
        }
        .commentList {
            padding:0;
            list-style:none;
            max-height:200px;
            overflow:auto;
        }
        .commentList li {
            margin:0;
            margin-top:10px;
        }
        .commentList li > div {
            display:table-cell;
        }
        .commenterImage {
            width:30px;
            margin-right:5px;
            height:100%;
            float:left;
        }
        .commenterImage img {
            width:100%;
            border-radius:50%;
        }
        .commentText p {
            margin:0;
        }
        .sub-text {
            color:#aaa;
            font-family:verdana;
            font-size:11px;
        }
        .actionBox {
            border-top:1px dotted #bbb;
            padding:10px;
}
    </style>
</head>
<body class>

<div class="detailBox">
    <div class="titleBox">
      <label>Comment Box For: <?php echo $_COOKIE['title_showlyrics'];?></label>

    </div>
    <div class="commentBox">

        <p class="taskDescription">So How was it?</p>
    </div>
    <?php
        $query_comment = "select * from `comments` where `comment_on` = '".$_COOKIE['title_showlyrics']."'";
        $data = $conn->query($query_comment);
        foreach($data as $row){

    echo '<div class="actionBox">
        <ul class="commentList">
            <li>
                <div class="commenterImage">
                  <img src="'.$_SESSION['picture'].'" alt="!"/>
                </div>
                <div class="commentText">
                    <p class="">'.$row['comment'].'</p> <span class="date sub-text">'.$row['published'].'</span>

                </div>
            </li>
        </div>';
        }
?>
        <form class="form-inline" method="get" role="form" action ="comment.php">
            <div class="form-group">
                <input class="form-control" name="comment" type="text" placeholder="Your comments"  required/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="sub" >Add</button>
                <a href="../index.php">Back To Home?</a> &nbsp; &nbsp; <a href="../lyrics/showlyrics.php?song=<?php echo
                $_COOKIE['title_showlyrics'] ?>">Back to lyrics?</a>
            </div>

        </form>
    </div>
</div>
</body>
</html>

<?php
    if(!loggedin()){
        header("Location:../index.php");
        exit();
    }

    if(isset($_COOKIE['title_showlyrics']) && isset($_GET['comment']) && isset($_GET['sub'])){
        $today = date("F j, Y, g:i a");
        $comment = $_GET['comment'];
        $newcomment_ = "@".$_SESSION['user'].": ".$_GET['comment'];
        $query = "insert into `comments`(`max_comment`,`comment_by`,`comment`,`comment_on`,`published`) values(DEFAULT,?,?,?,?)";
        $stmt =  $conn->prepare($query);
        $stmt->execute(array($_SESSION['user'],$newcomment_,$_COOKIE['title_showlyrics'],$today));
        header("Location:./comment.php");
        exit();



    }
?>
