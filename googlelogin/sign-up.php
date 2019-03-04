
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WritersPeak|Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FreeHTML5.co" />
	<link rel = "stylesheet" href = "../boot/css/bootstrap.min.css">
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
		
		div.content { width: 1500px }


    </style>
	<script type="text/javascript" src = "../boot/js/jquery-3.3.1.min.js"></script>
	<script type ="text/javascript">
		function checkUsername(){
			jQuery.ajax({
				url:"check.php",
				data:'username='+$("#username").val(),
				type:"POST",
				success:function(data){
					$("#feedback").html(data);
				},
				error:function(){}
			});
		}
	</script>
  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Pacifico&text=Writer's Peak" rel="stylesheet">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	
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
			<div class = "content">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					

					<!-- Start Sign In Form -->
					<form action="sign-up.php" method="POST" class="fh5co-form animate-box" data-animate-effect="fadeIn">
						
						<h2>Sign Up</h2>
						<span id ="feedback"></span>
						<div class="form-group">
							<label for="name" class="sr-only">Username</label>
							<input type="text" class="form-control" onkeyup="checkUsername()" id="username" min="4" max="7" name="username" placeholder="Username(Max:7Letters)" autocomplete="off" required="">
							
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required="">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required="">
						</div>
						<div class="form-group">
							<label for="re-password" class="sr-only">Re-type Password</label>
							<input type="password" class="form-control" id="re-password" name="repassword" placeholder="Re-type Password" autocomplete="off" required="">
						</div>
						
						<div class="form-group">
							<p>Already registered? <a href="login.php">Sign In</a></p>
						</div>
						<div class="form-group">
							<input type="submit" value="Sign Up" class="btn btn-primary">
						</div>
					</form>
					<!-- END Sign In Form -->

				</div>
			</div>
			
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
	
	<?php include "../components/footer.php" ?>
	</body>
</html>



<?php 
	require "../dbconfig/conn.php";
	include "../components/errorfunc.php";
	@$username = $_POST['username'];
	@$email = $_POST['email'];
	@$password = $_POST['password'];
	@$repassword = $_POST['repassword'];
	$options = [
		'cost' => 10,
	];

	$query = "select * from `users`";
	$stmt = $conn->query($query);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($data as $row){
		$retrieved_username = $row['username'];
	}

	if(isset($username) && !empty($username) && isset($email) && !empty($email) && isset($password) && !empty($password)
	&& isset($repassword) && !empty($repassword)){
		
		if(strlen($username)>7 && strlen($username)<4){
			echo '<script language="javascript">';
            echo 'alert("Failed,Username should be around 4 to 7 characters.")';
        	echo '</script>';
		}

		if($username == $retrieved_username){
			echo '<script language="javascript">';
            echo 'alert("User is already Registered, Please choose diffrent username.")';
        	echo '</script>';
		}
		
		if($password == $repassword){
			//echo $username.$email.$password.$repassword;
			$password_hash = @password_hash($password,PASSWORD_BCRYPT,['cost'=>10]);
			echo $password_hash;
			$sql = "insert into `users` (`id`,`username`,`password`,`email`) values(DEFAULT,'$username','$password_hash','$email')";
			$conn->exec($sql);
			
			echo '<script language="javascript">';
            echo 'alert("Registered Successfully.!")';
            echo '</script>';
			//echo 'matched';
		}else{
			echo '<script language="javascript">';
            echo 'alert("Passwords must be same.!")';
        	echo '</script>';
        	exit();
		}

	}

?>