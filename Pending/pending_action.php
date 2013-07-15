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
TODO:
	If the user modifies the name of the radio button,
	He may end up accepting a transaction, of which he has no right to

	check for such a condition the handle its error
*/

/*
TODO:
	What to do if no radio button of a name is checked?
*/

$query = "UPDATE `transaction` SET `status`=:status WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $ID );
$stmt->bindParam ( ":status", $status );

$query2 = "SELECT `from`, `to`, `amount`, `purpose` FROM `transaction` WHERE `ID`=:ID";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $ID );

$query3 = "SELECT COUNT(*), `ID` FROM `friendRelation` WHERE `friend1`=:from AND `friend2`=:to;";
$stmt3 = $dbh->prepare ( $query3 );
$stmt3->bindParam ( ":from", $from );
$stmt3->bindParam ( ":to", $to );

$query4 = "UPDATE `status` SET `status`=`status`+:amount WHERE `friendRelation`=:frndRel;";
$stmt4 = $dbh->prepare ( $query4 );
$stmt4->bindParam ( ":amount", $finalAmount );
$stmt4->bindParam ( ":frndRel", $frndRelID );

/*
	Generate a notification for it
*/
$query5 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt5 = $dbh->prepare ( $query5 );
$stmt5->bindParam ( ":ID", $_SESSION['id'] );
$stmt5->execute ( );
$rslt5 = $stmt5->fetch ( );
$currUserName = $rslt5['username'];

$query6 = "INSERT INTO `notification` ( `user_id`, `message`, `status` ) VALUES ( :frndID, :message, '0' );";
$stmt6 = $dbh->prepare ( $query6 );
$stmt6->bindParam ( ":frndID", $to_notification );
$stmt6->bindParam ( ":message", $message );

$username = XSS_encode ( $currUserName, 0 )[1];
/**/

$count = 0;

foreach ( $_POST['_'] as $ID=>$val )
{
	$count ++;

	if ( $val == 1 )	
	{
		$status = 1;
	}
	else if ( $val == -1 )
	{
		$status = -1;
	}
	else
	{
		echo "Technical error, something went wrong!";
		exit ( );
	}	
	
	$stmt->execute ( );
	
	if ( $status == 1 )
	{
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );
		$from = $rslt2['from'];
		$to = $rslt2['to'];
		$amount = $rslt2['amount'];
		$purpose = $rslt2['purpose'];
		
		$stmt3->execute();
		$rslt3 = $stmt3->fetch();	
		
		if ( $rslt3[0] == 1 )
		{
			$factor = -1;
			$finalAmount = $factor * $amount;
			$frndRelID = $rslt3['ID'];
		}
		else
		{
			$temp = $from;
			$from = $to;
			$to = $temp;
			
			$stmt3->execute();
			$rslt3 = $stmt3->fetch();
			
			if ( $rslt3[0] == 1 )
			{
				$factor = 1;
				$finalAmount = $factor * $amount;
				$frndRelID = $rslt3['ID'];
			}
			else
			{
				echo "Technical error, something went wrong!";
				exit ( );
			}
		}
		
		$stmt4->execute ( );
		
		if ( $to == $_SESSION['id'] )
		{
			$to_notification = $from;
		}
		else if ( $from == $_SESSION['id'] )
		{
			$to_notification = $to;
		}
		else
		{
			echo "Technical error, something went wrong!";
			exit ( );
		}
		$amount = XSS_encode ( $amount, 0 )[1];
		$purpose = XSS_encode ( $purpose, 0 )[1];
		$message = "<b>Transaction Approval : </b><u>$username</u> accepted a transaction ( Amount : $amount, Purpose : $purpose ).";
		$stmt6->execute ( );		
	}
	else
	{
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );
		$from = $rslt2['from'];
		$to = $rslt2['to'];
		$amount = $rslt2['amount'];
		$purpose = $rslt2['purpose'];
		
		if ( $to == $_SESSION['id'] )
		{
			$to_notification = $from;
		}
		else if ( $from == $_SESSION['id'] )
		{
			$to_notification = $to;
		}
		else
		{
			echo "Technical error, something went wrong!";
			exit ( );
		}
		$amount = XSS_encode ( $amount, 0 )[1];
		$purpose = XSS_encode ( $purpose, 0 )[1];
		$message = "<b>Transaction Rejection : </b><u>$username</u> rejected a transaction.";
		$stmt6->execute ( );		
	}
}


if ( $count == 0 )
{
	header ( "Location: pending_output.php?err_no=2" );
	exit ( );
}
else
{
	header ( "Location: pending_output.php" );
	exit ( );
}

?>
