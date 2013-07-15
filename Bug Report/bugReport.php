<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

$query = "INSERT INTO `bug` ( `user_id`, `report` ) VALUES ( :ID, :report );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->bindParam ( ":report", $_POST['desc'] );
$stmt->execute( );

header ( "Location: bugReport_output.php" );


?>
