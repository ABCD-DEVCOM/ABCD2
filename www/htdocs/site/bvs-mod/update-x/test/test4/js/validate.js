function VALIDATE_regexp ( validate, value )
{
	var pattern = new RegExp(validate);

	return pattern.test(value);
}

function UPDATE_X_validateItem ( item )
{
	var value = item.value;
	var iMessage = 0;

	switch ( item.path )
	{
		case "/Catalog/Book/@id":
			if ( value == "" )
			{
				iMessage = 1;
			}
			break;

		case "/Catalog/Book/Pages":
			if ( !VALIDATE_regexp("^[0-9]+$",value) )
			{
				iMessage = 2;
			}

			break;
			
	} // switch

	return iMessage;
}
