

<?php
require "./components/session.php";
require "./components/banner.php";
require "./components/errorfunc.php";
require "./dbconfig/conn.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <style>
      body {background-color:#000;}
          #posts {
            text-align: center;
            font-size: 0;
          }
          #posts .post {
            position: relative;
            width: 100%;
            height: 500px;
            margin: 0;
            border: 3px solid #000;
            display: inline-block;
            background-size: cover;
            background-position: center center;
            transition: all 300ms ease-out;
          }
          #posts .post h2 {
            color:#fff;
            position: absolute;
            bottom: 80px;
            margin: 0;
            font-size: 2vw;
            line-height: 0.8;
            font-family: 'MuseoSansRounded-900', 'Arial Black', sans-serif;
            padding: 0 60px;
            text-transform: uppercase;
            text-align: left;
            z-index: 1000;
          }
          #posts .post p {
            color:#fff;
            position: absolute;
            bottom: 40px;
            margin: 0;
            font-size: 1.5vw;
            line-height: 0.8;
            padding: 0 60px;
            text-transform: capitalize;
            text-align: left;
            z-index: 1000;
          }
          #posts .post:before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            background: #000;
            opacity: 0.5;
            -ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=50);
            filter: alpha(opacity=50);
            transition: all 300ms ease-out;
            content: '';
            z-index: 1;
          }
          #posts .post:hover:before {
            opacity: 0.2;
            -ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=20);
            filter: alpha(opacity=20);
          }



/* === MEDIA QUERIES === */

/* MOBILE FIRST */
/* XS */
/* SM */ @media (min-width: 34em) {#posts .post {width:50%;}}
/* MD */ @media (min-width: 48em) {#posts .post {width:25%;}}
/* LG */ @media (min-width: 62em) {#posts .post {width:33.33333333%;}}
/* XL */ @media (min-width: 75em) {#posts .post {width:25%;}}

    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel = "icon" href = "/var/www/html/writerspeak=/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
    </style>
    <title>WritersPeak|Home</title>
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./lyrics/lyricwizard.php">Publish Lyric</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="#">Policy</a>
      </li>
    </ul>
    <li class="form-inline my-2 my-lg-0 nav-item dropdown">
    <form class="form-inline my-2 my-lg-0"  method="post">
      <input class="form-control mr-sm-2" name="search_query" type="search" placeholder="Search Writer's Peak" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Search</button>
      <?php
      if(isset($_POST['search']) && isset($_POST['search_query'])){
       $search_query = $_POST['search_query'];
      @$findstring = substr($search_query, 0, 1) === "@";

    if($findstring){
        $str = ltrim($search_query, '@');
        //$query = "select * from `googleloginusers` where `username` = '".$str."' ";
        header("Location:./userops/indirect_profile.php?profile=".$str);
        exit();

    }else{
       header("Location:./userops/extended_search.php?q=".$search_query);
       exit();
    }
}?>
    </form>

          <span class = "text-dark">
          <?php

            if(isset($_SESSION['user'])){

                echo '<div class = "nav-item-dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                 echo $_SESSION['user']; echo '</a>';
               echo ' <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="./userops/profile.php">Profile</a>
                  <a class="dropdown-item" href="#">Manage Account</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./googlelogin/logout.php">Signout?</a>
                </div>';
                ?></span>

           <?php }else{
                echo "<a class='dropdown-item' href='./googlelogin/login.php'>Login</a> ";
                   }
          ?>
        </a>
                  </div>
    </li>
  </div>
</nav>
<?php
  $query = "select * from `lyrics`";
  $stmt = $conn->query($query);
?>
<br>
<section id="posts">
  <?php foreach($stmt as $row){
  echo '<a href="./lyrics/showlyrics.php?song='.$row["trimmedtitle"].'" title="'.$row['title'].' By '.$row['author'].'"
        class="post" style="background-image: url(\'./lyrics/'.$row['album_art'].'\');">
        <h2>"'.$row['title'].'"</h2><p class="lead">Written By @'.$row['author'].'
        &nbsp;<xmp>Likes</xmp> <i class="fab fa-gratipay"> </i></p></a>';
  }?>
</section>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>