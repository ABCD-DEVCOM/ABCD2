
<html>
	<head>
		<script language=javascript>
		 	function ComprobarPhp(){
		 		msgwin=window.open("info.php","php")
		 		msgwin.focus()
		 	}
		 	function ComprobarWxis(){
		 		msgwin=window.open("wxis.php","wxiswww")
		 		msgwin.focus()
		 	}
		 </script>
	</head>
	<body>
		<a href=Javascript:ComprobarPhp()>Click here to check if PHP is installed</a><br>
		<a href=Javascript:ComprobarWxis()>Click here to check if ABCD is well configured</a>
<!--		<form name=login action=testlogin.php method=post>
		<p>Test the acces via login and password<p>
		login: <input type=text name=login value=guilda>
		<br>password:<input type=text name=password value=g>
		<br>start as: <input type=text name=startas value=adm>
		<input type=submit value=test>
		<br>
		</form>  -->
	</body>
</html>