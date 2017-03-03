<?
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");

include("../common/header.php")
require_once ("../lang/admin.php");
?>
<script language=javascript>
function AbrirVentana(){
	msgwin=window.open("","Nuevo","resizable=yes,width=600,height=500,top=0, left=0,scrollbars=yes,status=yes")
	msgwin.focus()
}
function Copiar(Expresion){
	Obj=eval("top.window.opener.<?php echo $arrHttp["obj"]?>")
	Obj.value=Expresion
	self.close()
}
</script>
<body>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/alfa.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
	<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/alfa.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: alfa.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">

<form name=explora action=eliminararchivo.php >
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
$the_array = Array();
$Dir=$db_path.$arrHttp["base"]."/recursos";
$handle = opendir($Dir);
echo "<font face=verdana size=2><b>$Dir</b><br>";
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file))
   			if (strpos($file,$arrHttp["tipor"])===false){
   			}else{
            	$the_array[]=$file;
   			}
        else
            $dirs[]=$Dir."/".$file;
   }
}
closedir($handle);
$wks="";
if (isset($arrHttp["wks"])) $wks="&wks=".$arrHttp["wks"];
$wks.="&Dir=".$Dir;
sort ($the_array);
reset ($the_array);
echo "<table><td>";
echo "<table border=0  cellspacing=1 cellpadding=4 bgcolor=#cccccc>
     <tr><td ><Font size=1 face=arial color=red>".$msgstr["Eliminar"]."</td><td><Font size=1 face=arial color=red>Copiar</td><td></td>
	 <tr>
   			<td bgcolor=white width=10></td>
   			<td bgcolor=white></td>
   			<td bgcolor=white><font face=verdana size=2></td>";
while (list ($key, $val) = each ($the_array)) {
	 $fp=file("$Dir/$val");
	 $salida="";
	 foreach ($fp as $value) $salida.=trim($value)." ";
   echo "<tr>
   			<td bgcolor=white><input type=checkbox name=eliminar[] value=$val><img src=../img/delete.gif alt=\"eliminar este archivo\"></td>";



//			 if (isset($fp[1]))
//			 	$salida=trim($fp[1]);
//			 else
//			 	$salida=$fp[0];
			 echo "<td bgcolor=white><a href=\"javascript:Copiar('".str_replace("'","`",$salida)."')\"><img src=../img/copy_clipboard.gif border=0></a>
   				<td bgcolor=white><font face=verdana size=2>";
//   			echo $fp[0]."<br>";
			echo $salida;
	 	  	echo "</td>";
}
?>
<tr>
<td colspan=3><input type=submit value="Ejecutar"></td>
</table>
</td>
<tr>
<td valign=top >
<Font size=1 face=arial color=red>Eliminar: <font color=#222222>elimina la expresión<br>
<Font size=1 face=arial color=red>clic sobre el nombre de la búsqueda pasa la expresión al formulario
</td>
</table>

</form>
</body></html>