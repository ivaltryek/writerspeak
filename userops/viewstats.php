<?php

require "../components/banner.php";
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/customnav.php";
require "../components/session.php";

    if(!loggedin()){
        header("Location:../googlelogin/login.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WritersPeak|Stats</title>
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">

</head>
<body>
<?php
     echo "<script>document.title='WritersPeak|Stats';</script>";
 ?>
 <?php
    $query = "select * from `lyrics` where `trimmedtitle` = '".$_GET['song']."' ";
    $data = $conn->query($query);
    foreach($data as $d){
        $published = $d['published'];
        $title = $d['title'];
    }
 ?>
 <?php

    $stats_getter = "select `likes`,`dislike` from `lyrics` where `trimmedtitle` = ?";
    $stats_getter_prepare = $conn->prepare($stats_getter);
    $stats_getter_prepare->execute(array($_GET['song']));
    $stats_getter_array = $stats_getter_prepare->fetchAll(PDO::FETCH_ASSOC);
    foreach($stats_getter_array as $sg){
      $likes = $sg['likes'];
      $dislikes = $sg['dislike'];
    }

 ?>
 <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4"> Post: <?php echo $title ?></h1>
    <p class="lead">You can delete, update your post here and also shows the stats of the post.</p><br>
    <a class="text-danger" href="./deletepost.php?song=<?php echo $_GET['song'];?>">Delete?</a> &nbsp; &nbsp;
    <a class = "text-primary" href="./updatepost.php?song=<?php echo $_GET['song'];?>">Update?</a> &nbsp; &nbsp;
    <span class="glyphicon">&#x270f;</span><?php echo $published ?>
   &nbsp; <i class="fas fa-thumbs-up"></i> <?php
      if($likes < 0){
        echo '0';
      }else{
        echo $likes;
      }
    ?>
     &nbsp; <i class="fas fa-thumbs-down"></i> <?php
      if($dislikes < 0){
        echo '0';
      }else{
        echo $dislikes;
      }
    ?>
  </div></div><br><hr>
<div class = "container">
    <div class = "row">
        <div class = "col-md-7">
  Comments:<br>
  <?php
    $query = "select * from `comments` where `comment_on` = '".$_GET['song']."' ";
    $data = $conn->query($query);
    foreach($data as $dr){
        echo '<a  href="#" class="list-group-item list-group-item-action active">'.$dr['comment'].' &nbsp; &nbsp;
        <span class="glyphicon">&#x270f;</span>'.$dr['published'].'</a>'.'<br>';

    }
  ?>
    </div>
    </div>
    </div>

  </form>
</div>
</body>
</html>
