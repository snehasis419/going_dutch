<?php

function XSS_encode ( $str, $rule )
{
	switch ( $rule )
	{
		case 0	:	$retVal = XSS_encode_html ( $str );
							break;
							
		case 1	:	$retVal = XSS_encode_attribute ( $str );
							break;
							
		case 2	:	$retVal = XSS_encode_javasscript ( $str );
							break;
							
		case 3	:	$retVal = XSS_encode_css ( $str );
							break;
							
		case 4	:	$retVal = XSS_encode_url ( $str );
							break;
							
		default	:	$retVal = array ( -2, $str );		
	}
	
	return $retVal;
}

function XSS_encode_html ( $str )
{
	$str = str_replace ( '&', "&amp;", $str );
	$str = str_replace ( '<', "&lt;", $str );
	$str = str_replace ( '>', "&gt;", $str );
	$str = str_replace ( '"', " &quot;", $str );
	$str = str_replace ( '\'', " &#x27;", $str );
	$str = str_replace ( '/', "&#x2F;", $str );
	
	$retVal = array ( 0, $str );
	
	return $retVal;
}

function XSS_encode_attribute ( $str )
{
	$retVal = array ( -3, $str );
}

function XSS_encode_javascript ( $str )
{
	$retVal = array ( -3, $str );
}

function XSS_encode_css ( $str )
{
	$retVal = array ( -3, $str );
}

function XSS_encode_url ( $str )
{
	$retVal = array ( -3, $str );
}

?>
