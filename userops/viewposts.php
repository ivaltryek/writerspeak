<?php
    require "../components/banner.php";
    require "../components/customnav.php";
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
    <title>WritersPeak|Report</title>
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">
</head>
<body><br><?php
     echo "<script>document.title='WritersPeak|My Posts';</script>";
 ?>
 <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 align="left" class="display-4">My Posts</h1>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5">
        <div class="list-group">
            <?php
                $query = "select * from `lyrics` where `author` = '".$_SESSION['user']."' ";
                $data =  $conn->query($query);
                if($data->rowCount() == 0){
                    echo "Sorry, You have not posted anything yet. To post lyrics <a class='text-primary' href='../lyrics/lyricwizard.php'>click here!</a>";
                }else{
                foreach($data as $dr){
                    echo '<a  href="./viewstats.php?song='.$dr["trimmedtitle"].'" class="list-group-item list-group-item-action active">'.$dr['title'].'</a>'.'<br>';

                }
            }
            ?>