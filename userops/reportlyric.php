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
        if(!loggedin()){
            header("Location:../index.php");
        }
     echo "<script>document.title='WritersPeak|Report';</script>";
 ?>
    <form method="post" action="reportlyric.php">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class = "form-group">
                        <label for="reported_by">Reported By:</label>
                        <input type="text" class="form-control" name="reportedby"  value="<?php echo $_SESSION['user'] ?>" id="reported_by" required>
                    </div>
                    <div class="form-group">
                        <label for="reported_song">Reported Song:</label>
                        <input type="text" id="reported_song" name="reportedsong" value = "<?php echo $_SESSION['reportsong']?>" class="form-control"  required/>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="reason" rows="10" required cols="45" placeholder="Reasons like Irrelevent, CopyRight Infringement, off the topic.... Write the reason"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="commit" class="btn btn-danger">Report</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>


<?php
    if(isset($_POST['commit'])){
        //print_r($_POST);
    $report_query = "insert into `reports` (`id`,`reported_song`,`reported_by`,`reported_reason`) values (DEFAULT,?,?,?)";
    $stmt = $conn->prepare($report_query);
    if($stmt->execute(array($_SESSION['reportsong'],$_POST['reportedby'],$_POST['reason']))){
                echo '<script language="javascript">';
                echo 'alert("Thank You! For your valuable response")';
                echo '</script>';
                header("refresh:1;url=../index.php");
                exit();
    }else{
        //echo $stmt->errorInfo();
        header("Location:../error/index.html");
        exit();
        }
    }
?>