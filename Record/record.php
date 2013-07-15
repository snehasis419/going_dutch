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

$amnt = $_POST['amount'];
$date = $_POST['date'];
$dist = $_POST['distribution'];
$purpose = $_POST['purpose'];

$frndsInvolved = $_POST['involved'];
/*
	TODO:
	
	If the user modifies the value of the checkbox 'involved', inconsistency will arise.
	Because, the value of the checkbox decides to which user the transaction has to be remitted
		what if they're not friends?

	check for such a condition the handle its error
*/

/*
	TODO: Validation
*/

if ( $dist == 1 )
{
	$each = $amnt / count ( $frndsInvolved );
}
else if ( $dist == 2 )
{
	$each = $amnt;
}
else
{
	echo "Technical error, something went wrong!";
	exit ( );
}

$query = "INSERT INTO `transaction` ( `amount`, `date`, `from`, `to`, `purpose`, `status`) VALUES ( :amount, :date, :from, :to, :purpose, :status );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":amount", $amnt );
$stmt->bindParam ( ":date", $date );
$stmt->bindParam ( ":from", $from );
$stmt->bindParam ( ":to", $to );
$stmt->bindParam ( ":purpose", $purpose );
$stmt->bindParam ( ":status", $status );

$amnt = round ( $each, 2 );
$from = $_SESSION['id'];

/*
	Generate a notification for it
*/
$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $_SESSION['id'] );
$stmt2->execute ( );
$rslt2 = $stmt2->fetch ( );
$currUserName = $rslt2['username'];

$query3 = "INSERT INTO `notification` ( `user_id`, `message`, `status` ) VALUES ( :frndID, :message, '0' );";
$stmt3 = $dbh->prepare ( $query3 );
$stmt3->bindParam ( ":frndID", $to );
$stmt3->bindParam ( ":message", $message );

$username = XSS_encode ( $currUserName, 0 )[1];
/**/

foreach ( $frndsInvolved as $to )
{
	if ( $to == $_SESSION['id'] )
	{
		$status = 1;
	}
	else
	{
		$status = 0;
		
		$message = "<b>New Transaction : </b><u>$username</u> recorded a transaction with you as payee. It is waiting for your approval.";
		$stmt3->execute ( );
	}
	
	$stmt->execute ( );
	
}

header ( "Location: record_output.php" );
exit ( );

?>
