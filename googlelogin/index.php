<?php
    require_once "./config.php";
    $loginurl = $gClient->createAuthUrl();
    
?>


<html>
<head>
<title>Login with google</title>
</head>
<form action="" method = "post">
Email: <input type = "email" name = "email" /><br>
Password: <input type = "password" name = "pass"><br>
<input type = "submit" value = "login"> &nbsp; <input type = "button" onclick = "window.location = '<?php echo $loginurl;?>' " value = "Log in with google">
</form>
</html>