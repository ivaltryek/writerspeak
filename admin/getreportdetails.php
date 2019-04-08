<?php

require "../dbconfig/conn.php";
require "../components/session.php";
require "../components/errorfunc.php";

if (!is_admin_logged_in()){
    header("Location:../index.php");
}

$get_details_sql = "select * from `lyrics` where `trimmedtitle` = ?";
$get_details_sql_prepare = $conn->prepare($get_details_sql);
$get_details_sql_prepare->execute(array($_GET['id']));
$get_details_data = $get_details_sql_prepare->fetchAll(PDO::FETCH_ASSOC);
foreach($get_details_data as $gd){
    $author = $gd['author'];
    $title = $gd['title'];
    $lyrics = $gd['lyrics'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WritersPeak|Details</title>
</head>
<body>
<p>Author Name: <?php echo $author ?></p>
<p>Lyrics Title: <?php echo $title ?></p>
<p><textarea rows="50" cols="35"><?php echo $lyrics ; ?></textarea></p>
<br>
<p><a href="blockuser.php?user=<?php echo $author; ?>">Prevent Access to the Author!</a></p>
</body>
</html>