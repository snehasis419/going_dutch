<?php

require_once ( "../common/PHP/home.php" );

?>

<?php

$output = "";

if ( isset ( $_GET['err_no'] ) )
{
	$err_no = $_GET['err_no'];
	
	$error_style = "";
}
else
{
	$err_no = 0;
	
	$error_style = " style=\"display: none;\"";
}

?>

<?php

if ( $err_no == 1 )
{
	$output = "<strong>Username not available</strong>\n<button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\nPlease enter a different username.";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Sign Up</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>
	
	<div class="container-fluid">
		
		<form action="signUp.php" method="post" class="form-horizontal" style="text-align:center;">
		
			<div style="display:inline-block;">
			
				<label><h1><u>Sign Up</u></h1></label>
				<br>
				Thanks for your interest in <a href="<?php echo $HOME; ?>">Going Dutch</a>
				<br><br>
				Please fill out the form below to Sign Up
			
				<hr>
				
				<div class="alert alert-error"<?php echo $error_style; ?>>
					<?php echo $output; ?>
				</div>

				<div class="control-group">
					<label for="username" class="control-label">Username : </label>
					<div class="controls">
						<input type="text" name="username" id="username" onBlur="validate_username('username')">
					</div>
				</div>
				
				<div class="control-group">
					<label for="name" class="control-label">Name : </label>
					<div class="controls">
						<input type="text" name="name" id="name" onBlur="validate_name ('name')">
					</div>
				</div>

				<div class="control-group">
					<label for="password" class="control-label">Password : </label>
					<div class="controls">
						<input type="password" name="password" id="password">
					</div>
				</div>
				
				<div class="control-group">
					<label for="rePassword" class="control-label">Repeat Password : </label>
					<div class="controls">
						<input type="password" name="password" id="rePassword">
					</div>
				</div>
				
				<div class="control-group">
					<label for="email" class="control-label">E-Mail ID : </label>
					<div class="controls">
						<input type="email" name="email" id="email">
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-large btn-primary">Sign Up</button>
					</div>
				</div>
			
			</div>

		</form>
		
		<hr>
		
		<a href="../Log In/logIn_front.php" class="pull-right">Go to Login</a>
		
	</div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>

	<script src="validation.js"></script>
	
</body>

</html>
