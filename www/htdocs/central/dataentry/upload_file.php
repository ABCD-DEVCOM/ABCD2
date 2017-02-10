<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/admin.php");

?>
<html>

<head>
  <title><?php echo $msgstr["uploadfile"]?></title>
  <script>
  	function Explorar(){  		msgwin_ex=window.open("","dirsexplorer","width=800,height=600,resizable,scrollbars")
  		msgwin_ex.focus();
  		document.dirs_explore.submit()  	}

  </script>
</head>

<body link=black vlink=black bgcolor=white>
<font face=arial>
<form name=upload action=upload_img.php method=POST enctype=multipart/form-data>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Tag value=<?php echo $arrHttp["Tag"]?>>
<?php
$db=$arrHttp["base"];
if (!isset($_SESSION["permiso"]["CENTRAL_EDREC"]) and !isset($_SESSION["permiso"][$db."_CENTRAL_EDREC"])
and !isset($_SESSION["permiso"]["CENTRAL_CREC"])  and !isset($_SESSION["permiso"][$db."_CENTRAL_CREC"])
and !isset($_SESSION["permiso"]["CENTRAL_ALL"])
and !isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
	echo "<h4>".$msgstr[""]."</h4>";
	die;
}
echo $msgstr["storein"]?>: <input type=text name=storein size=40 value="<?php if (isset($arrHttp["storein"])) echo $arrHttp["storein"]?>" onfocus=blur()>
<a href=javascript:Explorar()><?php echo $msgstr["browse"]?></a>
<br>
<br>
<table width=400>
	<tr><td class=menusec1><?php echo $msgstr["archivo"]?></td>
	<tr><td><input name=userfile[] type=file size=80><br><input type=submit value='<?php echo $msgstr["uploadfile"]?>'></td>
</table>

</form>
<form name=dirs_explore action=dirs_explorer.php method=post target=dirsexplorer>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=tag value=<?php echo $arrHttp["Tag"]?>>

</body>

</html>