function VALIDATE_regexp ( validate, value )
{
	var pattern = new RegExp(validate);

	return pattern.test(value);
}

function UPDATE_X_validateItem ( item )
{
	var itemValue = item.value;
	var iMessage = 0;

	switch ( item.path )
	{
		case "/user/@code" :
			if ( itemValue == "" )
			{
				iMessage = 1;
			}
			break;			
	} // switch

	return iMessage;
}
