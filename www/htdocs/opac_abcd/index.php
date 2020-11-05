<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
	document.cookie = 'ORBITA; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'
	document.cookie =  'ORBITA=;';

/* Marcado y presentación de registros*/
function getCookie(cname) {
    var name = cname+"=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function Seleccionar(Ctrl){
	cookie=getCookie('ORBITA')
	if (Ctrl.checked){
		if (cookie!=""){
		    c=cookie+"|"
			if (c.indexOf(Ctrl.name+"|")==-1)
				cookie=cookie+"|"+Ctrl.name
		}else{
			cookie=Ctrl.name
		}
	}else{
		sel=Ctrl.name+"|"
		c=cookie+"|"
		n=c.indexOf(sel)
		if (n!=-1){
			cookie=cookie.substr(0,n)+ cookie.substr(n+sel.length)
		}

	}
	document.cookie="ORBITA="+cookie
	Ctrl=document.getElementById("cookie_div")
	Ctrl.style.display="inline-block"
}

function delCookie(){
  	document.cookie =  'ORBITA=;';

}
var user = getCookie("ORBITA");
  if (user != "") {
    alert("Welcome again " + user);
  } else {

    }

</script>
<?php
if (!file_exists("php/opac_dbpath.dat")){?>
   <meta http-equiv = "refresh" content = "2; url = php/index.php" />
</head>
</html>
<?php
}else {?>

	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
	<title>OPAC-ABCD</title>


</head>
<body>

<form name=inicio method=post action=php/index.php>
<?php
if (file_exists("php/opac_dbpath.dat")){
		$fp=file("php/opac_dbpath.dat");
		echo "DATABASE DIR: <select name=db_path id=db_path>\n";
		foreach ($fp as $value){
			if (trim($value)!=""){
				$v=explode('|',$value);
				$v[0]=trim($v[0]);
				echo "<Option value=".trim($v[0]).">".$v[1]."\n";
			}

		}
		echo "</select>";
	}
    echo "<P>";

    echo '<select name=lang >';
	//$fp=file($a);
	echo "<option value=en>english</option>";
	echo "<option value=es>spanish</option>";
	echo "<option value=es_utf8>spanish UTF-8</option>";
?>
</SELECT>
<input type=hidden name=primeravez value=Y>
<input type=submit value=go>
</form>
<?php } ?>