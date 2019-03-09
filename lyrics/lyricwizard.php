<!DOCTYPE html>
<html>
    <head>
        <title>WritersPeak|LyricWizard</title>
        <link rel="stylesheet" href="../boot/css/bootstrap.min.css">
        <script src="../boot/js/jquery-3.3.1.min.js"></script>
    </head>
    <body class="bg-light">
        <?php

            require "../components/banner.php";
            require "../components/session.php";

        ?>
        <center>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">LyricWizard</h4>
            <hr>
            <p class="mb-0">Post your album art,Song title and Song lyrics, and you're good to go!</p>
        </div>
        </center>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                <form method="POST" action="lyricwizard.php">
                <div class="form-group">
                <div class="custom-file">
                <label for="exampleInputEmail1">Written By:</label>

                <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['user']; ?>" disabled>
            </div><br><br>
            <div class="form-group">
            <div class = "form-check">
                 <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_album_art" value="album_art">
                 <label class="form-check-label" for="exampleCheck1">Has an Album Art?</label>
            </div>
            <div class="form-group">
             <input type = "text" style="font-weight:bold;" name="title" class="form-control" placeholder="Song Title" required/>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="lyrics" rows="45" placeholder="your lyrics goes here..." cols="200" required></textarea>
            </div>
            <div class="form-group">
                <input type = "submit" name="submit" value="Post" class="btn btn-success form-control"/>
            </div>

        </form>
                </div>
            </div>

        </div>
        <!-- </div> -->
    </body>
</html>

<?php
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
$trimmedtitle = "";
    if(isset($_POST['submit'])){
        //$username = $_POST['username'];
        $title = $_POST['title'];
       // echo $title."t";
        $lyrics = $_POST['lyrics'];
        @$trimmedtitle = preg_replace("/[^a-zA-Z]/", "", $title);
        $cookie_name = "title";
        $cookie_value = $trimmedtitle;
        setcookie($cookie_name,$cookie_value,time() + (86400 * 30), "/");
        //$_SESSION['title_edited'] = @$trimmedtitle;
        //echo $trimmedtitle;
        $today = date("F j, Y, g:i a");
        $query = "insert into `lyrics`(`id`,`author`,`album_art`,`title`,`lyrics`,`trimmedtitle`,`published`) values(DEFAULT,?,DEFAULT,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($_SESSION['user'],$title,$lyrics,$trimmedtitle,$today));

        if(isset($_POST['is_album_art'])){

            header("Location:setupalbumart.php");
        }else{
            header("Location:../index.php");
        }

    }


?>