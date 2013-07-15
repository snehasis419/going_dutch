function validate_number ( id )
{
	var elem = document.getElementById ( id );

	var pat = /^[0-9]+$/;

	if ( pat.test ( elem.value ) )
	{
		elem.style.backgroundColor = "lightgreen";
		return true;
	}
	else
	{
		elem.style.backgroundColor = "red";
		alert ( "Amount should be Non - Empty\n\nIt should contain only Digits" );
		tempElem = elem;
		setTimeout("this.tempElem.focus ( );",0);
		return false;
	}
}

function validate_date_curr ( id )
{
	var elem = document.getElementById ( id );

	if ( validate_date ( elem.value, "-" ) != 0 )
	{
		elem.style.backgroundColor = "red";
		alert ( "Invalid Date" );
		tempElem = elem;
		setTimeout("this.tempElem.focus ( );",0);
		return false;
	}
	else
	{
		if ( greater_than_current ( elem.value ) )
		{
			elem.style.backgroundColor = "red";
			alert ( "Date cannot be greater than current date!" );
			tempElem = elem;
			setTimeout("this.tempElem.focus ( );",0);
			return false;
		}
		else
		{
			elem.style.backgroundColor = "lightgreen";
			return true;
		}
	}
}

function greater_than_current ( date )
{
	var date_components = date.split ( "-" );
		
	var day = parseInt ( date_components[0] );
	var month = parseInt ( date_components[1] );
	var year = parseInt ( date_components[2] );

	var currentTime = new Date();
	var currMonth = currentTime.getMonth() + 1;
	var currDay = currentTime.getDate();
	var currYear = currentTime.getFullYear();



	if ( year > currYear )
	{
		return true;
	}
	else if ( year === currYear && month > currMonth )
	{
		return true;
	}
	else if ( year === currYear && month === currMonth && day > currDay )
	{
		return true;
	}
	else
	{
		return false;
	}

}

function validate_date ( date, delim )
{
	var str = "^[0-9]{1,2}" + delim + "[0-9]{1,2}" + delim + "[0-9]{4}$";
	var pat = new RegExp ( str );
	
	if ( ! pat.test ( date ) )
	{
		return 1;
	}
	else
	{
		var date_components = date.split ( delim );
		
		var day = parseInt ( date_components[0] );
		var month = parseInt ( date_components[1] );
		var year = parseInt ( date_components[2] );
		
		if ( day === 0 || month === 0 || year === 0 )
		{
			return ( day === 0 ) ? ( 2 ) : ( ( month === 0 ) ? ( 3 ) : ( 4 ) );
		}
		else if ( month > 12 )
		{
			return 5;
		}
		else if ( ( month === 1 || month === 3 || month === 5 || month === 7 || month === 8 || month === 10 || month === 12 ) && ( day > 31 ) )
		{
			return 6;
		}
		else if ( ( month === 4 || month === 6 || month === 9 || month === 11 ) && ( day > 30 ) )
		{
			return 7;
		}
		else if ( month === 2  )
		{
			if ( ( year % 4 ) === 0 )
			{
				if ( day > 29 )
				{
					return 8;
				}
			}
			else if ( day > 28 )
			{
				return 9;
			}
		}
	}
	
	return 0;
}
