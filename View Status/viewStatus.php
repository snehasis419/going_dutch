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

$query = "SELECT `ID` FROM `friendRelation` WHERE ( `friend1`=:ID OR `friend2`=:ID );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$frndRels = array ( );
foreach ( $rslt as $val )
{
	array_push ( $frndRels, $val['ID'] );
}

$query = "SELECT `friend1`, `friend2`, `status` FROM `status`, `friendRelation` WHERE ( `friendRelation`.`ID`=`status`.`friendRelation` ) AND ( `friendRelation`=:frndRel );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":frndRel", $frndRel );

$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $frndID );

$info = array ( );
foreach ( $frndRels as $frndRel )
{
	$stmt->execute ( );
	$rslt = $stmt->fetch ( );
	
	if ( $stmt->rowCount ( ) != 0 )
	{
		$status = $rslt['status'];
	
		$frndID = $rslt['friend1'];
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );	
		$frnd1 = $rslt2['username'];
	
		$frndID = $rslt['friend2'];
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );	
		$frnd2 = $rslt2['username'];
	
		array_push ( $info, array ( $frnd1, $frnd2, $status ) );
	}
}

foreach ( $info as $key=>$val )
{
	$info[$key][0] = XSS_encode ( $val[0], 0 )[1];
}

$query = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
$ourGuy = $rslt['username'];

?>

<?php

$final = array ( );

//profit
$outputProfit = "";
foreach ( $info as $key=>$val )
{
	if ( $val[0]==$ourGuy && $val[2]<0 )
	{
		$outputProfit .= "<div class=\"cell\">\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputProfit .= "\t<div class=\"cell\">" . ( -1 * $val[2] ) . "</div>\n";
		$outputProfit .= "</div>\n\n";
		array_push ( $final, array ( $val[1], abs ( $val[2] ) ) );
	}
	
	if ( $val[1]==$ourGuy && $val[2]>0 )
	{
		$outputProfit .= "<div class=\"cell\">\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputProfit .= "</div>\n\n";
		array_push ( $final, array ( $val[0], abs ( $val[2] ) ) );
	}
}

//no profit - no loss
$outputNeutral = "";
foreach ( $info as $val )
{
	if ( $val[0]==$ourGuy && $val[2]==0 )
	{
		$outputNeutral .= "<div class=\"cell\">\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputNeutral .= "</div>\n\n";
		
		array_push ( $final, array ( $val[1], $val[2] ) );
	}
	
	if ( $val[1]==$ourGuy && $val[2]==0 )
	{
		$outputNeutral .= "<div class=\"cell\">\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputNeutral .= "</div>\n\n";
		array_push ( $final, array ( $val[0], $val[2] ) );
	}
}

//loss
$outputLoss = "";
foreach ( $info as $val )
{
	if ( $val[0]==$ourGuy && $val[2]>0 )
	{
		$outputLoss .= "<div class=\"cell\">\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputLoss .= "</div>\n\n";
		array_push ( $final, array ( $val[1], ( -1 * abs ( $val[2] ) ) ) );
	}
	
	if ( $val[1]==$ourGuy && $val[2]<0 )
	{
		$outputLoss .= "<div class=\"cell\">\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputLoss .= "\t<div class=\"cell\">" . ( -1 * $val[2] ) . "</div>\n";
		$outputLoss .= "</div>\n\n";
		array_push ( $final, array ( $val[0], ( -1 * abs ( $val[2] ) ) ) );
	}
}

$output = "";

usort ( $final, function($a, $b) { return $a[1] - $b[1]; } );

foreach ( $final as $val )
{
	if ( $val[1] > 0 )
	{
		$tr_class = "success";
	}
	else if ( $val[1] == 0 )
	{
		$tr_class = "";
	}
	else if ( $val[1] < 0 )
	{
		$tr_class = "error";
	}
	else
	{
		echo "Technical error, something went wrong!";
		exit ( );
	}
	
	$output .= "<tr class=\"$tr_class\">\n";
	$output .= "\t<td style=\"text-align: right;\">" . $val[0] . "</td>\n";
	$output .= "\t<td>" . abs ( $val[1] ) . "</td>\n";
	$output .= "</tr>\n\n";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Current Status</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<div class="container-fluid">
	
		<div class="row-fluid">
	
			<table class="table table-striped table-hover">
	
				<caption>
					<div class="container-fluid"><div class="row-fluid">
					<span class="offset2 span3" style="background-color: rgba(0, 255, 0, 0.3); padding-top: 5px">Money owed to you</span>
					<span class="offset2 span3" style="background-color: rgba(255, 0, 0, 0.3); padding-top: 5px">Money you owe</span>
					</div></div>
			
					<br><hr><br>
			
				</caption>
		
				<thead  class="text-big">
					<tr>
						<th style="text-align: right;">Friend</th>
						<th>Amount</th>
					</tr>
				</thead>
		
				<tbody class="text-big">
		
					<?php echo $output; ?>
			
				</tbody>
	
			</table>
		
		</div>
	
		<hr>
	
		<div class="row-fluid">
	
			<a href="../Home/home.php" class="offset5 span2 btn btn-primary btn-large">Go Home</a>
		
		</div>
	
	</div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
