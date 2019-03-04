
<?php
session_start();
if (!isset($_SESSION['access_token'])) {
    header("Location: login.php");
}

?>

<?php
require "../components/banner.php";
require "../dbconfig/conn.php";
require "../components/errorfunc.php";
$firstname = $_SESSION['givenName'];
$lastname = $_SESSION['familyName'];
$picture = $_SESSION['picture'];
$email = $_SESSION['email'];
$select_query = "select * from `googleloginusers` where `email` = ?";
$data = $conn->prepare($select_query);
$data->execute(array($email));

if($data->rowCount() > 0){
    $row = $data->fetchAll(PDO::FETCH_ASSOC);
    foreach($row as $r){$username = $r['username'];}
    $_SESSION['user'] = $username;
    header("Location:../index.php");
}else{
$query = "insert into `googleloginusers` (`id`,`firstname`,`lastname`,`profilepic`,`email`) values(DEFAULT,?,?,?,?)";
$stmt = $conn->prepare($query);
$stmt->execute(array($firstname, $lastname, $picture, $email));
    if($stmt->rowCount() == 0){
        "<script type='text/javascript'>
         alert('Something wierdly just happened, Try again Please.!');
        </script>";
    }else{
        header("Location:./setupprofile.php");
    }

}
?>
