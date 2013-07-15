<?php

require_once( '../common/PHP/common_session.php' );

if ( isset ( $_SESSION['logged-in'] ) && $_SESSION['logged-in'] == true )
{
	header ( "Location: ../Home/home.php" );
}

?>

<?php

$error_style = " style=\"display: none;\"";
$info_style = " style=\"display: none;\"";
$output = "";

if ( isset ( $_GET['err_no'] ) )
{
	$err_no = $_GET['err_no'];
}
else
{
	$err_no = 0;
}

?>

<?php

if ( $err_no == 1 )
{
	$error_style = "";
	$output = "<button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Username does not exist!</strong><br>\nAre you sure you entered the correct username?";
}
else if ( $err_no == 2 )
{
	$error_style = "";
	$output = "<button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Username and Password do not match.</strong><br>\nAre you sure these are your credentials?";
}
else if ( $err_no == 3 )
{
	$info_style = "";
	$output = "<button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Logout Successful!</strong>";
}
else if ( $err_no == 4 )
{
	$error_style = "";
	$output = "<button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Log In to see that page!</strong><br>\nMaybe your session got timed out ...";
}

?>

<!DOCTYPE html>

<html>

<head>

	<title>Log In</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
	<style>
	
	</style>
	
</head>

<body id="logIn-body">

	<br><br>

	<div class="container-fluid">
	
		<div class="alert alert-error"<?php echo $error_style; ?>>
			<?php echo $output; ?>
		</div>
	
		<div class="alert alert-info"<?php echo $info_style; ?>>
			<?php echo $output; ?>
		</div>
	
		<div class="row-fluid">
			<div class="offset1 span3" id="logIn-form">
			
				<form action="logIn.php" method="post">
					<fieldset>
			
						<legend>
							<h1>Log In</h1>
						</legend>
						
						<input type="text" name="username" id="username" placeholder="Username"><br>
						<input type="password" name="password" id="password" placeholder="Password"><br>
						<br>						
						<button type="submit" class="btn btn-large btn-primary">Go!</button>
						
						<br><br><br>
						
						Not Registered?
						<a href="../Sign Up/signUp_front.php" class="btn btn-large">Sign Up</a>
				
					</fieldset>
				</form>
				
			</div>			
		</div>
			
	</div>	
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
