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

$query = "SELECT `friend1`, `friend2` FROM `friendRelation` WHERE `friend1`=:ID OR `friend2`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$frndList = array ( );
foreach ( $rslt as $val )
{
	if ( $val['friend1'] == $_SESSION['id'] )
	{
		array_push ( $frndList, $val['friend2'] );
	}
	else
	{
		array_push ( $frndList, $val['friend1'] );
	}
}
array_push ( $frndList, $_SESSION['id'] );

?>

<?php

$query = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $frndID );

$output = "";
$data = "";
$divIDArray = "Array ( ";
foreach ( $frndList as $key=>$frndID )
{
	$stmt->execute ( );
	$rslt = $stmt->fetch ( );
	
	$frndName = XSS_encode ( $rslt[0], 0 )[1];
	
	$data .= "\"" . XSS_encode ( $frndName, 0 )[1] . "\",";
	
	$output .= "<div style=\"display: inline;\" id=\"$frndName\">\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"involved[]\" id=\"frnd_$key\" value=\"$frndID\" style=\"display: none;\"><label class=\"box\" for=\"frnd_$key\">$frndName</label>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
	
	$divIDArray .= "\"$frndName\", ";
}
$divIDArray = rtrim ( $divIDArray, ', ' );
$divIDArray .= " );\n";

$data = rtrim ( $data, ',' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Record New Transaction</title>
	
	<link rel="stylesheet" href="../common/CSS/temp2.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
	<script>
	divIDs = <?php echo $divIDArray; ?>
	</script>
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<br><br>
	
	<form class="form-horizontal" action="record.php" method="post">
		
		<div class="container-fluid">
		
			<div class="row-fluid">
			
				<div class="offset1 span4">
				
					<div class="control-group">
						<label for="amount" class="control-label">Amount : </label>
						<div class="controls">
							<input type="text" name="amount" id="amount" onBlur="validate_number('amount')">
						</div>
					</div>
					
					<div class="control-group">
						<label for="date" class="control-label">Date of Transaction : </label>
						<div class="controls">
							<input type="date" name="date" id="date" placeholder="30-06-1992" onBlur="validate_date_curr('date')">
						</div>
					</div>
					
					<div class="control-group">
						<label for="purpose" class="control-label">Purpose :</label>
						<div class="controls">
							<input type="text" name="purpose" id="purpose">
						</div>
					</div>
					
					<div class="control-group border">
						<div class="text-center">How is the amount distributed?</div>
						<br>
						
						<div class="container-fluid"><div class="row-fluid">
						
						<div class="offset1 span4">
							<input type="radio" name="distribution" id="equally" value="1" checked="checked" class="hide"><label for="equally" class="pull-left pad-small text-center red"><img src="../common/images/equally.png" class="long-icon">Equally</label>
						</div>
						
						<div class="offset2 span4">
						<input type="radio" name="distribution" id="individually" value="2" class="hide"><label for="individually" class="pull-right pad-small text-center red"><img src="../common/images/individually.png" class="long-icon">Individually</label>
						</div>
						
						</div></div>
						
					</div>
				
				</div>
				
				<div class="offset2 span4">
				
					Friends involved in this transaction: -
					
					<br><br>
					
					<div class="input-prepend">
						<span class="add-on"><i class="icon-search"></i></span>
						<!--
						<input type="text" data-provide="typeahead" data-source='[<?php echo $data; ?>]' data-items="5" autocomplete="off" style="margin: 0 auto;" id="searchTerm" onKeyUp="divVisibility()">
						-->
						<input type="text" id="searchTerm" onKeyUp="divVisibility()">
					</div>
					
					<br><br>
		
					<div>

						<?php echo $output; ?>
								
					</div>
				
				</div>
			
			</div>
			
			<div class="row-fluid text-center">
			
				<hr>
				
				<button type="submit" class="btn btn-large btn-primary">Record Transaction</button>
			
			</div>
		
		</div>
		
	</form>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
	<script src="../common/JS/divVisibility.js"></script>
	<script src="validation.js"></script>
	
</body>

</html>
