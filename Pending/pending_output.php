<?php

require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

if ( isset ( $_GET['err_no'] ) )
{
	switch ( $_GET['err_no'] )
	{
		case 1	:	$output = "<div class=\"offset3 span6 alert alert-info text-center\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button><strong>Hurrah!</strong><br>You have no Pending transactions.</div>";
							break;
		
		case 2	:	$output = "<div class=\"offset3 span6 alert alert-info text-center\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button><strong>No transaction selected!</strong><br>That's fine. You can accept/reject your pending transactions anytime.</div>";
							break;
		
		default	:	$output = "Technical error, something went wrong!";
	}
}
else
{
	$output = "<div class=\"offset3 span6 alert alert-success text-center\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button><strong>Success!</strong><br>Pending transactions processed successfully</div>";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Transactions Report</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<div class="container-fluid"><div class="row-fluid">
	
	<?php echo $output; ?>
	
	</div></div>
	
	<br><br>
	
	<div class="row-fluid text-center">
					
		<br><br>
		
		<a href="../Home/home.php" class="btn btn-large btn-primary">Go Home</a>

	</div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
