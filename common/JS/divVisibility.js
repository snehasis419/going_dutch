function divVisibility ( )
{
	pattern = new RegExp ( document.getElementById ( "searchTerm" ).value );
	
	if ( document.getElementById ( "searchTerm" ).value === "" )
	{
		for ( key in divIDs )
		{
			document.getElementById ( XSS_decode ( divIDs[key] ) ).style.display = "inline";
		}
	}
	else
	{
		for ( key in divIDs )
		{
			if ( pattern.test ( XSS_decode ( divIDs[key] ) ) )
			{
				document.getElementById ( XSS_decode ( divIDs[key] ) ).style.display = "inline";
			}
			else
			{
				document.getElementById ( XSS_decode ( divIDs[key] ) ).style.display = "none";
			}
		}
	}
}

function XSS_decode ( str )
{
	str = str.replace(/&amp;/g, '&');
	str = str.replace(/&lt;/g, '<');
	str = str.replace(/&gt;/g, '>');
	str = str.replace(/&quot;/g, '"');
	str = str.replace(/&#x27;/g, '\'');
	str = str.replace(/&#x2F;/g, '/');
	
	return str;
}
