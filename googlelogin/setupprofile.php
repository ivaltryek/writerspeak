<?php
session_start();
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
require "../components/banner.php";
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WritersPeak|SetUpUser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../boot/css/bootstrap.min.css">
</head>
<body>

    <br>
    <form  action = "setupprofile.php">

    <div class="form-row align-items-center">

    <div class="col-sm-3 my-1">
      <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">@</div>
        </div>
        <input type="text" maxlength="14" name="username" minlength="3" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username" required />
      </div>
    </div>
    <div class="col-auto my-1">
      <input type="submit" class="btn btn-outline-primary" name="submit" value="Submit" />
    </div>
  </div>
    </form>

</body>
</html>


<?php
    //print_r($_SESSION);
    //print_r($_GET);
    if(isset($_GET['submit']) && isset($_SESSION['email'])){
    $select_query = "select * from `googleloginusers` where `username` = ?";
    $stmt2=$conn->prepare($select_query);
    $stmt2->execute(array($_GET['username']));

      if($stmt2->rowCount()>0){
          echo '<script language="javascript">';
          echo 'alert("Username is already exists, try with diffrent username.! Thank you.")';
          echo '</script>';
          exit();
      }else{
            $query = "update `googleloginusers` set `username` = ? where `email` = ? ";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($_GET['username'],$_SESSION['email']));
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
    }
?>