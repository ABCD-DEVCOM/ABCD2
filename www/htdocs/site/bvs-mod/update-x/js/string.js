function STRING_replace ( strFrom, strFind, strReplace )
{
	var arrayFrom = strFrom.split(strFind);
	return arrayFrom.join(strReplace);
}
