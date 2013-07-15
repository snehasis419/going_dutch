<?php

require_once ( '../common/PHP/common_database.php' );

?>

<?php

$err_no = 0;

$query = "SELECT COUNT(*) FROM `user_auth` WHERE `username`=:username;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":username", $_POST['username'] );
$stmt->execute ( );
$rslt = $stmt->fetch ( );

if ( $rslt[0] > 0 )
{
	$err_no = 1;
}
else
{
	$query = "INSERT INTO `user_auth` ( `username`, `password` ) VALUES ( :username, :password );";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":username", $_POST['username'] );
	$randomString = "F()(K()";
	$stmt->bindParam ( ":password", hash ( "sha256", ( $_POST['password'] . $randomString ) ) );
	$stmt->execute ( );
	
	$query = "INSERT INTO `user_data` ( `ID`, `name`, `email` ) VALUES ( :ID, :name, :email );";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":ID", $dbh->lastInsertId ( ) );
	$stmt->bindParam ( ":name", $_POST['name']  );
	$stmt->bindParam ( ":email", $_POST['email']  );
	$stmt->execute ( );
		
	$err_no = 0;
}

?>

<?php

if ( $err_no == 0 )
{
	header ( "Location: signUp_success.html" );
}
else if ( $err_no == 1 )
{
	header ( "Location: signUp_front.php?err_no=$err_no" );
}
else
{
	echo "Technical error, something went wrong!";
}

?>
