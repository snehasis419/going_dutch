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

$query = "SELECT * FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

if ( $stmt->rowCount ( ) == 0 )
{
	header ( "Location: pending_output.php?err_no=1" );
	exit ( );
}
else
{
	$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
	$stmt2 = $dbh->prepare ( $query2 );
	
	$output = "";
	
	foreach ( $rslt as $trans )
	{
		$stmt2->bindParam ( ":ID", $trans['from'] );
		$stmt2->execute ( );		
		$rslt2 = $stmt2->fetch ( );
		$fromName = $rslt2[0];
		
		$ID = $trans['ID'];
		
		$output .= "<tr class=\"pending\">\n";
		$output .= "\t\t\t\t\t<td>" . XSS_encode ( $trans['date'], 0 )[1] . "</td>\n";
		$output .= "\t\t\t\t\t<td>" . XSS_encode ( $trans['amount'], 0 )[1] . "</td>\n";
		$output .= "\t\t\t\t\t<td>" . XSS_encode ( $fromName, 0 )[1] . "</td>\n";
		$output .= "\t\t\t\t\t<td>" . XSS_encode ( $trans['purpose'], 0 )[1] . "</td>\n";
		$output .= "\t\t\t\t\t<td>" . "<input type=\"radio\" name=\"_[$ID]\" id=\"_[$ID]_1\" value=\"1\" class=\"hide\"><label for=\"_[$ID]_1\" class=\"smallBox inline\"><a class=\"btn btn-success\">Accept</a></label>" .  "</td>\n";
		$output .= "\t\t\t\t\t<td>" . "<input type=\"radio\" name=\"_[$ID]\" id=\"_[$ID]_-1\" value=\"-1\" class=\"hide\"><label for=\"_[$ID]_-1\" class=\"smallBox inline\"><a class=\"btn btn-danger\">Reject</a></label>" .  "</td>\n";
		$output .= "\t\t\t\t</tr>\n";
		
		$output .= "\t\t\t\t";
	}
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Transactions</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<form action="pending_action.php" method="post">
		
		<table class="table table-striped table-hover">
		
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount</th>
					<th>From</th>
					<th>Purpose</th>
					<th>Accept</th>
					<th>Reject</th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php echo $output; ?>
				
			</tbody>
		
		</table>
		
		<br><hr><br>
		
		<div class="container-fluid"><div class="row-fluid">
			<button type="submit" class="offset5 span2 center btn btn-primary btn-large">Go</button>
		</div></div>
		
	</form>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
