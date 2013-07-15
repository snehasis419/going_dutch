<?php

require_once ( '../common/PHP/common_database.php' );

if ( ! @include_once ( 'https://raw.github.com/Fa773NM0nK/Fa773N_M0nK-library/master/PHP/XSS%20Protection/XSS_encode.php' ) )
{
	require_once ( '../common/Fa773N_M0nK-library/PHP/XSS Protection/XSS_encode.php' );
}

?>

<?php

$err_no = 0;

$query = "SELECT `ID`, `password` FROM `user_auth` WHERE `username`=:username";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":username", $_POST['username'] );
$stmt->execute ( );

$query2 = "SELECT `name` FROM `user_data` WHERE `ID`=:ID";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $ID );

if ( $stmt->rowCount ( ) == 0 )
{
	$err_no = 1;
}
else
{
	$rslt = $stmt->fetch ( );
	
	$randomString = "F()(K()";
	if ( hash ( "sha256", ( $_POST['password'] . $randomString ) ) == $rslt['password'] )
	{
		session_destroy ( );
		session_start ( );
		
		$_SESSION['logged-in'] = true;
		$_SESSION['id'] = $ID = $rslt['ID'];
		
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );
		
		$_SESSION['name'] = XSS_encode ( $rslt2['name'] )[1];
		
		$err_no = 0;
	}
	else
	{
		$err_no = 2;
	}
}

?>

<?php

if ( $err_no == 0 )
{
	header ( "Location: ../Home/home.php" );
}
else if ( $err_no == 1 )
{
	header ( "Location: logIn_front.php?err_no=$err_no" );
}
else if ( $err_no == 2 )
{
	header ( "Location: logIn_front.php?err_no=$err_no" );
}
else
{
	echo "Technical error, something went wrong!";
}

?>
