<?php
session_start();
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/banner.php";
?>


<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src = "../boot/js/jquery-3.3.1.min.js"></script>
    <script type ="text/javascript">
      function checkUsername(){
        jQuery.ajax({
          url:"check_profile.php",
          data:'username='+$("#username").val(),
          type:"POST",
          success:function(data){
            $("#feedback").html(data);
          },
          error:function(){}
        });
      }
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WritersPeak|SetUpUser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../boot/css/bootstrap.min.css">
</head>
<body>

    <br>
    <center><div id="feedback"></div></center>
    <form  action = "setupprofile.php">

    <div class="form-row align-items-center">

    <div class="col-sm-3 my-1">
      <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
      <div class="input-group">

        </div>
      </div>
    </div>
      <div class ="container">
        <div class="row">
          <div class = "col-5">
          <div class="input-group-prepend">
          <div class="input-group-text">@</div>
          <input type="text" maxlength="14" id="username" onkeyup="checkUsername()" name="username" minlength="3" class="form-control" id="inlineFormInputGroupUsername" <?php if(isset($_GET['msg'])){echo 'value='.$_SESSION['user'];}else{echo 'placeholder="Username"';} ?> autofocus required title="Please enter a username" />
          </div><br>
            <input type="text" name="about_me" class="form-control" placeholder="About you" /><br>
            <textarea name="more_content" placeholder="Tell us more about yourself" rows="5" cols="30" ></textarea><br><br>
            <input type="submit" class="btn btn-outline-primary" name="submit" value="Submit" />
          </div>
        </div>
      </div>

   <?php

    if(isset($_GET['msg']) && isset($_GET['submit'])){
      header("Location:../userops/profile.php");
    }

   ?>

  </div>
  <br>
    </form>

</body>
</html>


<?php
    //print_r($_SESSION);
    //print_r($_GET);
    if(isset($_GET['submit']) && isset($_SESSION['email'])){
    // $select_query = "select * from `googleloginusers` where `username` = ?";
    // $stmt2=$conn->prepare($select_query);
    // $stmt2->execute(array($_GET['username']));
    //   if($stmt2->rowCount()>0){
    //       echo '<script language="javascript">';
    //       echo 'alert("Username is already exists, try with diffrent username.! Thank you.")';
    //       echo '</script>';
    //       exit();
    //   }else{
            $query = "update `googleloginusers` set `username` = ?, `about_me` = ?, `more_content` = ? where `email` = ? ";
            $stmt = $conn->prepare($query);
            $stmt->execute(array(trim($_GET['username']),$_GET['about_me'],$_GET['more_content'],$_SESSION['email']));
            $result = $stmt->rowCount();
            echo $result;
            if($stmt->rowCount()>0){
                $_SESSION['user'] = $_GET['username'];
                header("Location:../index.php");
                exit();
            }else{
                header("Location:../error/index.html");
                exit();
            }
      }
   // }
?>