<?php

require_once ( 'common_session.php' );
require_once ( 'common_home.php' );

if ( $_SESSION['logged-in'] != true )
{
	session_destroy ( );
	header ( "Location: $HOME/Log In/logIn_front.php?err_no=4" );
}

?>
