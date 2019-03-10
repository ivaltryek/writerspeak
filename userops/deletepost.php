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
    <title>WritersPeak|DeletePost</title>
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">

</head>
<body>
<?php
     echo "<script>document.title='WritersPeak|DeletePost';</script>";
 ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Delete Post: <?php echo $_GET['song']; ?></h1>
    <p class="lead">By deleting this post, this won't be recoverable, and you need to use your <span class="text-primary">Master Password</span> to delete this post.<br>
If you haven't created yet then <a class="text-primary" href="./setupmaster.php">Click Here! </a></p>
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
                        <button type="submit" name="commit" class="btn btn-danger">Delete Post?</button>
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
                    $delete_post = "delete from `lyrics` where `trimmedtitle` = '".$_GET['song']."' ";
                    $delete_post_comment = "delete from `comments` where `comment_on` = '".$_GET['song']."' ";
                    $conn->query($delete_post);

                    echo "<script type='text/javascript'>
                    alert('Post has been deleted Successfully.!');
                    location = 'http://localhost/writerspeak/userops/viewposts.php';
                     </script>";
                     exit();
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