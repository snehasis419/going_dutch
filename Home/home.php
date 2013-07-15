<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

if ( ! @include_once ( 'https://raw.github.com/Fa773NM0nK/Fa773N_M0nK-library/master/PHP/XSS%20Protection/XSS_encode.php' ) )
{
	require_once ( '../common/Fa773N_M0nK-library/PHP/XSS Protection/XSS_encode.php' );
}

?>

<?php

/*
	Check if there are any pending requests wrt. this user
*/
$query = "SELECT COUNT(*) FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );

if ( $rslt[0] == 0 )
{
	$pendingDiv_display = "none";
}
else
{
	$pendingDiv_dispaly = "block";
}
/**/

/*
	Generating Alerts
*/
$query = "SELECT COUNT(*) FROM `friendRequest` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
if ( $rslt[0] > 0 )
{
	$frnd_disable = "";
	$frnd_text = "Accept / Reject Friend Requests";
	$frndImg_aHref = "../Friend/friendRequest_action_front.php";
}
else
{
	$frnd_disable = "disable";
	$frnd_text = "No Pending Friend Request";
	$frndImg_aHref = "#";
}

$query = "SELECT COUNT(*) FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
if ( $rslt[0] > 0 )
{
	$trns_disable = "";
	$trns_text = "Accept / Reject Transactions";
	$trns_aHref = "../Pending/pending_front.php";
}
else
{
	$trns_disable = "disable";
	$trns_text = "No Pending Transactions";
	$trns_aHref = "#";
}
/**/

?>

<!DOCTYPE html>

<html>

<head>
	<title>Home</title>
	
	<link rel="stylesheet" href="../common/CSS/temp4.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<div class="container-fluid">	
	
		<div class="row-fluid">
		
			<a href="../View Status/viewStatus.php" class="btn btn-large btn-inverse offset1 span10">
				View Current Status
			</a>
			
		</div>
		
		<hr>
		
		<div class="row-fluid">
		
			<ul class="thumbnails text-center text-info">
			
				<li class="offset2 span3">
					<a href="../Friend/befriend_front.php" class="thumbnail">
					<img src="../common/images/addFriend.png" data-src="holder.js/100x100" style="width: 100px; height: 100px;">
					</a>
					Add Friend
				</li>
				
				<li class="offset2 span3 <?php echo $frnd_disable; ?>">
					<a href="<?php echo $frndImg_aHref; ?>" class="thumbnail"">
					<img src="../common/images/accept-reject.png" data-src="holder.js/100x100" style="width: 100px; height: 100px;" tooltip="<?php echo $frnd_tooltip; ?>">
					</a>
					<?php echo $frnd_text; ?>
				</li>
				
			</ul>
		
		</div>
		
		<hr>
		
		<div class="row-fluid">
		
			<ul class="thumbnails text-center text-info">
			
				<li class="offset1 span2">
					<a href="../Record/record_front.php" class="thumbnail">
					<img src="../common/images/newTransaction.png" data-src="holder.js/100x100" style="width: 100px; height: 100px;">
					</a>
					Record New Transaction
				</li>
				
				<li class="offset2 span2 <?php echo $trns_disable; ?>">
					<a href="<?php echo $trns_aHref; ?>" class="thumbnail">
					<img src="../common/images/pendingTrns.png" data-src="holder.js/100x100" style="width: 100px; height: 100px;">
					</a>
					<?php echo $trns_text; ?>
				</li>
				
				<li class="offset2 span2">
					<a href="../View Transactions/viewTransactions_front.php"" class="thumbnail">
					<img src="../common/images/viewTrns.jpg" data-src="holder.js/100x100" style="width: 100px; height: 100px;">
					</a>
					View Transactions
				</li>
				
			</ul>
		
		</div>
		
	</div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
