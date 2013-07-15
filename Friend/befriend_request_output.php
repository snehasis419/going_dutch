<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<?php

if ( isset ( $_GET['err_no'] ) )
{
	switch ( $_GET['err_no'] )
	{
		case 1	:	$output = "<div class=\"alert alert-error\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Error!</strong><br>\nGiven username does not exist.</div>";
							break;
		case 2	:	$output = "<div class=\"alert alert-info\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Friends Already!</strong><br>\nYou are already friends, so this request cannot be sent.</div>";
							break;
		case 3	:	$output = "<div class=\"alert alert-block\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Pending Request!</strong><br>\nA request from you is already pending.</div>";
							break;
		case 4	:	$output = "<div class=\"alert alert-block\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Pending Request!</strong><br>\nThe specified user has already sent a request to you, please attend to that request.</div>";
							break;
		case 5	:	$output = "<div class=\"alert alert-block\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Self Request!</strong><br>\nAre you sending a request to youself because you are \"Forever Alone\"?</div>";
							break;
		
		default	:	$output = "Technical error, something went wrong!";
							exit ( );
	}
}
else
{
		$output = "<div class=\"alert alert-success\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button>\n<strong>Success!</strong><br>\nFriend Request sent successfully.</div>";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Befrinding Report</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<div class="hero-unit text-center">
	
		<?php echo $output; ?>
		
		<br><br>
		
		<a href="befriend_front.php" class="offset2 span2 btn btn-warning btn-large">Another Request</a>
		<a href="../Home/home.php" class="offset4 span2 btn btn-success btn-large">Go Home</a>
		
	<div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
