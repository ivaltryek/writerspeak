<?php
require_once "./config.php";
$loginurl = $gClient->createAuthUrl();

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WritersPeak|Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">



    <meta name="author" content="Mj" />
    <link rel="stylesheet" href="../boot/css/bootstrap.min.css">
    <style>
        nav {
            font-family: 'Pacifico', serif;
            font-size: 48px;
            color: white;
            align: center !important;
            text-align: center !important;
        }

        .navbar-header {
            float: left;
            padding: 15px;
            text-align: center;
            width: 100%;
        }

        .navbar-brand {
            float: none;
        }

        .navbar .navbar-collapse {
            text-align: center !important;
        }
    </style>


    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&text=Writer's Peak" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">


    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>

    <nav class="navbar navbar-default bg-danger position-fixed" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" style="color:white; font-size:39px;" href="#">Writer's Peak</a>
        </div>
    </nav>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">


            <!-- Start Sign In Form -->
            <form action="login.php" method="post" class="fh5co-form animate-box" data-animate-effect="fadeIn">
                <h2>Sign In</h2>
                <div class="form-group">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" required="Username is supposed to get filled">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required="Password is supposed to get filled">
                </div>

                <div class="form-group">
                    <p>Not registered? <a href="sign-up.php">Sign Up</a></p>
                    <!-- | <a href="forgot.html">Forgot Password?</a> -->
                </div>
                <div class="form-group">
                    <input type="submit" value="Sign In" name="local_login" class="btn btn-success"> &nbsp;

                <button type = "button" class="btn btn-danger" name="google_login" onclick = "window.location = '<?php echo $loginurl; ?>' " >  Log In With   <i class="fab fa-google"></i> </button>
                </div>

            </form>
            <!-- END Sign In Form -->

        </div>


    </div>


    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Placeholder -->
    <script src="js/jquery.placeholder.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>


    <?php include "../components/footer.php"?>

</body>

</html>



<?php

require "../dbconfig/conn.php";
require "../components/errorfunc.php";
if (isset($_POST['local_login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "select * from `users` where `username` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($username));

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                $password_hash = $row['password'];
            }
            if (password_verify($password, $password_hash)) {
                echo '<script language="javascript">';
                echo 'alert("Logged In Successfully.!")';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("Wrong Credentials, Please try again.")';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("Wrong Credentials, Please try again.")';
            echo '</script>';
        }
    }
}
?>