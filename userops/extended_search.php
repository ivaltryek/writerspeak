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
    <title>WritersPeak|ExtendedSearch</title>
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron jumbotron-fluid ">
  <div class="container">
    <h1 class="display-4">You've searched for... <?php echo $_GET['q'] ?></h1>
    <p class="lead">All results has been calculated on the requested query.</p>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5">
        <div class="list-group">
        <?php

if(isset($_GET['q'])){
    $search_data = $_GET['q'];
    $search_data_ = preg_replace("/[^a-zA-Z]/", "", $search_data);
    $search_query = "select * from `lyrics` where `trimmedtitle` like '%$search_data_%' ";
    $data_result = $conn->query($search_query);
    foreach($data_result as $dr){
  echo '<a  href="../lyrics/showlyrics.php?song='.$dr["trimmedtitle"].'" class="list-group-item list-group-item-action active">'.$dr['title'].'</a>'.'<br>';
}
}?>
<!-- <a href="search_data.php" class="list-group-item list-group-item-action">lol</a> -->
</div>
        </div>
    </div>
</div>
</body>
</html>