<!-- Dynamic Version by: Nannette Thacker -->
	<!-- http://www.shiningstar.net -->
	<!-- Original by :  Ronnie T. Moore -->
	<!-- Web Site:  The JavaScript Source -->
	<!-- Use one function for multiple text areas on a page -->
	<!-- Limit the number of characters per textarea -->
	<!-- Begin
	function textCounter(field,cntfield,maxlimit) {
		if (field.value.length > maxlimit) // if too long...trim it!
			field.value = field.value.substring(0, maxlimit);
			// otherwise, update 'characters left' counter
		else
			cntfield.value = maxlimit - field.value.length;
	}
	//  End -->