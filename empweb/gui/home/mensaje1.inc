<div class="searchBox">
<form name="myForm">
	<table border="0">
		<tr>
			<td><label for="userid"><strong>User ID:</strong></label></td>
			<td><input type="text" name="userid" id="userid" size="30" class="mytextEntry"></td>
		</tr>
			<td><input type="button" value="Close" onclick="closeWindow()">
			<input type="button" value="Send" onclick="sendQueryForUser()"></td>
		</tr>
	</table>
	<script type="text/javascript">
	document.myForm.userid.focus();
	</script>
</form>
</div>