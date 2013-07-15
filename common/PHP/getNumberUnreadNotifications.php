<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

function getNumberUnreadNotifications ( )
{
	global $dbh;
	
	$query = "SELECT COUNT(*) FROM `notification` WHERE `user_id`='" . $_SESSION['id'] . "' AND `status`='0';";
	$stmt = $dbh->prepare ( $query );

	$stmt->execute ( );
	$rslt = $stmt->fetch ( );
	
	return $rslt[0];
}

?>
