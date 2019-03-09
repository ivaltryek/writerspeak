<?php

    require "../dbconfig/conn.php";
    require "../components/banner.php";
    require "../components/session.php";
    require "../components/errorfunc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">
    <title>WritersPeak|SetUpAlbumArt</title>
</head>
<body class="bg-light">
    <br>
    <form action="setupalbumart.php" method="post" enctype="multipart/form-data">

        <div class="container">
        <div class="row">
        <input type="hidden" name="hidden_title">
        <input type="file" class="form-control col-md-5" name="myfile" id="fileToUpload">
        <input type="submit" name="submit" class="btn btn-primary" value="Upload File" >
        </div>
        </div>
    </form>
</body>
</html>

<?php
    $currentDir = getcwd();
    $uploadDirectory = "/upload/";

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

    @$fileName = $_FILES['myfile']['name'];
    @$fileSize = $_FILES['myfile']['size'];
    @$fileTmpName  = $_FILES['myfile']['tmp_name'];
    @$fileType = $_FILES['myfile']['type'];
    @$fileExtension = strtolower(end(explode('.',$fileName)));
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
    if (isset($_POST['submit'])) {
        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 2000000) {
            $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo "The file " . basename($fileName) . " has been uploaded";
                $newfilename = "upload/".$fileName;
                $query = "update `lyrics` set `album_art` = '".$newfilename."' where `trimmedtitle` = '".$_COOKIE['title']."' and `author` = '".$_SESSION['user']."'";
                $stmt = $conn->prepare($query);
                if($stmt->execute()){
                    //echo "Uploaded to DB";
                    //echo $stmt->errorInfo();
                    header("Location:../index.php");
                    exit();
                }else{
                    echo "OOps,Please try again later";
                }
            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
            }
        }
    }


?>
