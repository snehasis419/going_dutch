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

$query = "SELECT `username` FROM `user_auth`;";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$users = array ( );
foreach ( $rslt as $user )
{
	array_push ( $users, $user['username'] );
}

?>

<?php

$output = "";
foreach ( $users as $user )
{
	$output .= "&quot;" . XSS_encode ( $user, 0 )[1] . "&quot;,";
}
$output = rtrim ( $output, ',' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Select Friend</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<div class="container">

			<form action="befriend_request.php" method="post" class="form-inline offset4 span8">
			
				<h2>Add Friend</h2>
				
				<br><hr><br>
			
				<label for="friendUsername">Enter Friend's Username : </label><br>
				<input type="text" name="friendUsername" data-source="[<?php echo $output; ?>]" data-items="5" data-provide="typeahead" autocomplete="off" style="margin: 0 auto;" class="span3">
				<button type="submit" class="btn">Add as Friend</button>
			</form>

    </div>	
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
