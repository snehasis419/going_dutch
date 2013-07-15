<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>View Transactions</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<form action="viewTransactions.php" method="post">
		
		<div class="container-fluid">
		
			<div class="row-fluid viewTrns">
			
				<ul class="thumbnails text-center text-info">
			
					<li class="offset2 span3">
						<input type="checkbox" name="type_payer" id="type_payer" value="1" class="hide">
						<label for="type_payer" class="border">
							<img src="../common/images/payer.png" data-src="holder.js/100x100" style="width: 384px; height: 128px;"><br>
							Transaction where you payed for your friends
						</label>
					</li>
					
					<li class="offset2 span3">
						<input type="checkbox" name="type_payee" id="type_payee" value="2" class="hide">
						<label for="type_payee" class="border">
							<img src="../common/images/payee.png" data-src="holder.js/100x100" style="width: 384px; height: 128px;"><br>
							Transaction where your friends payed for you
						</label>
					</li>
				
				</ul>
		
			</div>
			
			<br><hr><br>
		
			<div class="row-fluid text-center">
		
				<input type="checkbox" name="approved" id="approved" checked="chekced" class="hide"><label class="offset1 span2 box border" for="approved">Approved Transactions</label>
				
				<input type="checkbox" name="pending" id="pending" class="hide"><label class="offset2 span2 box border" for="pending">Pending Transactions</label>
				
				<input type="checkbox" name="rejected" id="rejected" class="hide"><label class="offset2 span2 box border" for="rejected">Rejected Transactions</label>
		
			</div>
			
			<div class="row-fluid">
			
				<br><hr><br>
			
				<button type="submit" class="offset5 span2 btn btn-primary btn-large">Go</button>
			</div>
			
		</div>
	
		
	</form>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
