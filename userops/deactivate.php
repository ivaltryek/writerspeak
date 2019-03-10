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
    <title>WritersPeak|Deactivate</title>
</head>
<body>
<?php
     echo "<script>document.title='WritersPeak|Deactivate';</script>";
 ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Deactivate Account</h1>
    <p class="lead">By Deactiving, Your profile will be deleted permenantly and all data will be lost, Be sure to perform this submission.</p>
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
                        <button type="submit" name="commit" class="btn btn-danger">Deactivate</button>
                        </div>
    </div>
  </form>
</div>

</body>
</html>

<?php
    if(isset($_POST['commit']) && isset($_POST['master']) &&
    isset($_POST['re_master'])){
    $sql = "select * from `googleloginusers` where `username` = '".$_SESSION['user']."' ";
    $data = $conn->query($sql);
    $master = $_POST['master'];
    $re_master = $_POST['re_master'];

        if($master != $re_master){
            echo '<script language="javascript">';
            echo 'alert("Password must be same!")';
            echo '</script>';
        }else{
            if($data->rowCount()> 0){
                foreach($data as $d){
                    $password_hash_ = $d['master_password'];
                }
                if(password_verify($master,$password_hash_)){
                    $delete_user = "delete from `googleloginusers` where `username` = '".$_SESSION['user']."' ";
                    $conn->query($delete_user);
                    session_destroy();
                    echo "<script type='text/javascript'>
                    alert('Happy Farewell.!');
                    location = 'http://localhost/writerspeak/index.php';
                     </script>";
                }else{
                    echo '<script language="javascript">';
                    echo 'alert("Wrong Credentials, Please try again.")';
                    echo '</script>';
                }
            }else{
                    header("Location:../error/index.html");
                    exit();
            }
        }
    }

?>