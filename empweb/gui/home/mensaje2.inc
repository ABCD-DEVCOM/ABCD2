<div class="searchBox">
<form name="myFormObject">
	<table border="0">
		<tr>
			<td><label for="userid"><strong>Copy ID:</strong></label></td>
			<td><input type="text" name="copyid" id="copyid" size="30" class="mytextEntry"></td>
		</tr>
			<td><input type="button" value="Close" onclick="closeWindow()">
			<input type="button" value="Send" onclick="sendQueryForObject()"></td>
		</tr>
	</table>
	<script type="text/javascript">
	document.myFormObject.copyid.focus();
	</script>
</form>
</div>