<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Bug Report</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	  <div class="container-fluid">
	  
			<div class="row-fluid text-center">
				<h1><u>Bug Report</u></h1>
				
				Thanks for taking time out to report bugs
			</div>
			
			<br><hr><br>
	  
	  	<div class="row-fluid">
	  
				<form action="bugReport.php" method="post" class="form-horizontal offset3 span8">
				
					<div class="control-group">
						<label class="control-label" for="desc">Bug Description</label>
						<div class="controls">
							<textarea name="desc" id="desc" cols="40" rows="6"></textarea>
						</div>				
					</div>
			
					<div class="control-group">
						<div class="controls">
							<a href="<?php echo $HOME; ?>" class="btn btn-large btn-primary">Go Home</a>
							<button type="submit" class="btn btn-large btn-warning">Submit</button>
						</div>
					</div>
					
				</form>
    
		</div>
    
	</div>

	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
