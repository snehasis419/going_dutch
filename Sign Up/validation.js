function validate_username ( id )
{
	var elem = document.getElementById ( id );

	var pat = /^[a-zA-Z0-9]+$/;

	if ( pat.test ( elem.value ) )
	{
		elem.style.backgroundColor = "lightgreen";
		return true;
	}
	else
	{
		elem.style.backgroundColor = "red";
		alert ( "Username should be Non - Empty\n\nIt should contain only Letters and Numbers" );
		tempElem = elem;
		setTimeout("this.tempElem.focus ( );",0);
		return false;
	}
}

function validate_name ( id )
{
	var elem = document.getElementById ( id );

	var pat = /^[a-zA-Z\ ]+$/;

	if ( pat.test ( elem.value ) )
	{
		elem.style.backgroundColor = "lightgreen";
		return true;
	}
	else
	{
		elem.style.backgroundColor = "red";
		alert ( "Name should be Non - Empty\n\nIt should contain only Letters and Spaces" );
		tempElem = elem;
		setTimeout("this.tempElem.focus ( );",0);
		return false;
	}
}