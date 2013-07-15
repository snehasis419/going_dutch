<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Friend Request Report</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<div class="container-fluid">
	
		<div class="row-fluid">
	
			<div class="alert alert-success offset3 span6">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!</strong><br>Friend Requests processed successfully!
			</div>
			
		</div>
		
		<div class="row-fluid text-center">
						
			<br><br>
			
			<a href="../Home/home.php" class="btn btn-large btn-primary">Go Home</a>
	
		</div>
	
	</div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
