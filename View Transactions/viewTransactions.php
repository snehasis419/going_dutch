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

$firstFlag = true;

function put ( $when, $what, $whatElse, &$flag, &$query )	//0: first;	1: not first
{
	if ( ( $when == 0 && $flag == true ) || ( $when == 1 && $flag == false ) )
	{
		$query .= " $what";
		
		if ( $flag == true ) $flag = false;
		
		return true;
	}
	else if ( ( $when == 0 && $flag == false ) || ( $when == 0 && $flag == true ) )
	{
		$query .= " $whatElse";
		
		if ( $flag == true ) $flag = false;
		
		return true;
	}
	else
	{
		return false;
	}
}

$query = "SELECT * FROM `transaction`";

if ( ! ( isset ( $_POST['type_payer'] ) || isset ( $_POST['type_payee'] ) ) )
{
	$anyFlag = false;
}
else
{
	if ( isset ( $_POST['type_payer'] ) )
	{
		put ( 0, "WHERE (", "OR", $firstFlag, $query );
	
		$query .= " `from`='" . $_SESSION['id'] . "'";
	}

	if ( isset ( $_POST['type_payee'] ) )
	{
		put ( 0, "WHERE (", "OR", $firstFlag, $query );
	
		$query .= " `to`='" . $_SESSION['id'] . "'";
	}
	
	if ( $firstFlag == false )
	{
		$query .= " )";
	}

	$firstFlag = true;

	if ( ! ( isset ( $_POST['approved'] ) || isset ( $_POST['pending'] ) || isset ( $_POST['rejected'] ) ) )
	{
		$anyFlag = false;
	}
	else
	{
		$anyFlag = true;
	
		if ( isset ( $_POST['approved'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='1'";
		}
	
		if ( isset ( $_POST['pending'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='0'";
		}
	
		if ( isset ( $_POST['rejected'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='-1'";
		}
	}
}

if ( $firstFlag == false )
{
	$query .= " )";
}

$query .= " ORDER BY `date` DESC;";


if ( $anyFlag == false )
{
	$output = "<div class=\"alert alert-warning text-center\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button><strong>Problem!</strong><br>No type of transaction selected</div>";
	$headingDiv_style = " style=\"display: none\"";
}
else
{
	$stmt = $dbh->prepare ( $query );
	$stmt->execute ( );
	$rslt = $stmt->fetchAll ( );
	
	echo $stmt->errorInfo()[2];

	if ( $stmt->rowCount ( ) == 0 )
	{
		$output = "<div class=\"alert alert-warning text-center\"><button data-dismiss=\"alert\" class=\"close\" type=\"button\">&times;</button><strong>Problem!</strong><br>No transactions match the given criterion</div>";
		$headingDiv_style = " style=\"display: none\"";
	}
	else
	{
		$headingDiv_style = "";
		
		$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
		$stmt2 = $dbh->prepare ( $query2 );
	
		$output = "";
	
		foreach ( $rslt as $trans )
		{
			$stmt2->bindParam ( ":ID", $trans['from'] );
			$stmt2->execute ( );		
			$rslt2 = $stmt2->fetch ( );
			$fromName = $rslt2[0];
			
			$stmt2->bindParam ( ":ID", $trans['to'] );
			$stmt2->execute ( );		
			$rslt2 = $stmt2->fetch ( );
			$toName = $rslt2[0];
		
			if ( $trans['status'] == -1 )
			{
				$tr_class = "error";
			}
			else if ( $trans['status'] == 0 )
			{
				$tr_class = "warning";
			}
			else if ( $trans['status'] == 1 )
			{
				$tr_class = "success";
			}
			else
			{
				echo "Technical error, something went wrong!";
				exit ( );
			}
		
			$output .= "<tr class=\"$tr_class\">\n";
			$output .= "\t\t\t<td>" . XSS_encode ( $trans['date'], 0 )[1] . "</td>\n";
			$output .= "\t\t\t<td>" . XSS_encode ( $trans['amount'], 0 )[1] . "</td>\n";
			$output .= "\t\t\t<td>" . XSS_encode ( $fromName, 0 )[1] . "</td>\n";
			$output .= "\t\t\t<td>" . XSS_encode ( $toName, 0 )[1] . "</td>\n";
			$output .= "\t\t\t<td>" . XSS_encode ( $trans['purpose'], 0 )[1] . "</td>\n";
			$output .= "\t\t</tr>\n";
		
			$output .= "\t\t";

		}
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
	
	<table class="table table-striped table-hover"<?php echo $headingDiv_style; ?>>
	
		<caption>
			<div class="container-fluid"><div class="row-fluid">
			<span class="offset2 span2" style="background-color: rgb(213, 236, 191); padding-top: 5px">Approved transaction</span>
			<span class="offset1 span2" style="background-color: rgba(255, 255, 0, 0.5); padding-top: 5px">Pending transaction</span>
			<span class="offset1 span2" style="background-color: rgb(242, 189, 177); padding-top: 5px">Rejected transaction</span>
			</div></div>
		</caption>
		
		<thead>
			<th>Date</th>
			<th>Amount</th>		
			<th>From</th>
			<th>To</th>
			<th>Purpose</th>
		</thead>
		
		<tbody>
		
			<?php echo $output; ?>
			
		</tbody>
	
	</table>
	
	<div class="container-fluid"><div class="row-fluid">
	
		<a href="../Home/home.php" class="offset5 span2 btn btn-primary btn-large">Go Home</a>
		
	</div></div>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
