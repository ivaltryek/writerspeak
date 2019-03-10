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
    <title>WritersPeak|MasterPassword</title>
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">

</head>
<body>
<?php
     echo "<script>document.title='WritersPeak|SetUpMaster';</script>";
 ?>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Master Password Creation</h1>
    <p class="lead">Use of master password is to deactivate your account.</p>
  </div>
  <form method="post">
    <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class = "form-group">
                            <label for="reported_by">Enter Password:</label>
                            <input type="password" class="form-control" name="master"   id="reported_by" required>
                        </div>

                        <div class = "form-group">
                            <label for="reported_by">Re-Enter Password:</label>
                            <input type="password" class="form-control" name="re_master" " id="reported_by"  required>
                        </div>
                        <div class="form-group">
                        <button type="submit" name="commit" class="btn btn-primary">Create</button>
                        </div>
    </div>
  </form>
</div>
</body>
</html>

<?php
    if(isset($_POST['commit']) && isset($_POST['master']) &&
    isset($_POST['re_master'])){
        $master = $_POST['master'];
        $re_master = $_POST['re_master'];

        if($master != $re_master){
            echo '<script language="javascript">';
            echo 'alert("Password must be same!")';
            echo '</script>';
        }else{
        $password_ = @password_hash($master,PASSWORD_BCRYPT,['cost'=>10]);
        $sql = "update `googleloginusers` set `master_password` = ? where `username` = ?";
        $stmt = $conn->prepare($sql);
        if($stmt->execute(array($password_,$_SESSION['user']))){
            echo "<script type='text/javascript'>
                    alert('Password created successfully');
                    location = 'http://localhost/writerspeak/index.php';
                </script>";
            exit();
        }else{
            echo $stmt->errorInfo();
              }
        }
    }
?>