<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;
echo "<font face=arial size=1>Script: leertxt.php";

$fp="";
if (isset($arrHttp["archivo"])) {
	$folder="pfts";
	$arch=explode('|',$arrHttp["archivo"]);  //[0]=NAME [1]=TYPE OF OUTPUT: CT=COLS.TABLE  CD=COLS.DELIMITED
	$arrHttp["archivo"]=$arch[0];
	if (!isset($arch[1])) $arch[1]="";
	echo "<script>type='".$arch[1]."'</script>\n";
	$type="";
	if (isset($arrHttp["tipof"])) $type="|".$arrHttp["tipof"];
	if (isset($arrHttp["Opcion"])and $arrHttp["Opcion"]=="guardar") {
		echo "<font face=verdana size=2>Formato: <b>$a</b></font><br>";
    	$fp=fopen($db_path.$arrHttp["base"]."/www/".$arrHttp["archivo"].".pft","w",0);
		fputs($fp, stripslashes( $arrHttp["formato"])); #write all of $data to our opened file
  		fclose($fp); #close the file
		echo " Guardado!!</center>";
		$arrHttp["pft"]="S";
	}
	unset($fp);
	$len=strpos($arrHttp["archivo"],'.pft');
	if ($len>0)
		$arrHttp["archivo"]=substr($arrHttp["archivo"],0,$len);
	$file=$db_path.$arrHttp["base"]."/$folder/".$_SESSION["lang"]."/" .$arrHttp["archivo"].".pft";
	if (file_exists($file)){        $fp=file($file);
	}else{
		$file=$db_path.$arrHttp["base"]."/$folder/".$lang_db."/" .$arrHttp["archivo"].".pft";
		$fp=file($file);
	}

	if (!$fp){		if ($arrHttp["desde"]!="recibos"){
  			echo $msgstr["misfile"]." ". $arrHttp["archivo"];
		}else{
			$file=$db_path.$arrHttp["base"]."/$folder/".$_SESSION["lang"]."/" .$arrHttp["archivo"].".pft";			$fp=array();		}
	}
}else{

}
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>ABCD. Display format edit</title>
<meta http-equiv="content-language" content="en">
<meta name="robots" content="all">
<meta name="robots" content="index">
<meta name="robots" content="follow">
<meta http-equiv="expires" content="Mon, 01 Jan 1990 00:00:00 GMT">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta name="revisit-after" content="1 day">
<meta http-equiv="content-script-type" content="text/javascript">
<script languaje=javascript>

function ActualizarFormato(){	document.forma1.action="pft_update.php"
	document.forma1.submit()}
function Enviar(){
	window.opener.document.forma1.pft.value=document.forma1.pftedit.value
	if (heading=="Y")
		window.opener.document.forma1.headings.value=document.forma1.headings.value
	window.opener.EsconderVentana('createformat')
	window.opener.toggleLayer('createformat')
//CHECK THE OPENER FORM WITH THE TYPE OF OUTPUT
	switch (type){		case "CT":
			window.opener.document.forma1.tipof[2].checked =true
			break
		case "CD":
			window.opener.document.forma1.tipof[3].checked =true
			break	}
	self.close()
}
</script>

<body><font color=black>
<form name=forma1 action=leertxt.php method=post><p>
<?php
if (isset($arrHttp["base"]))	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
if (isset($arrHttp["desde"]))
	echo "<input type=hidden name=desde value=".$arrHttp["desde"].">\n";
if (isset($arrHttp["archivo"]))
	echo "<input type=hidden name=nombre value=".$arrHttp["archivo"].">\n";
if (isset($arrHttp["descripcion"]))
	echo "<input type=hidden name=descripcion value=".$arrHttp["descripcion"].">\n";

echo $msgstr["edit"]." ".$msgstr["pft"].": ".$arrHttp["archivo"];
if (isset($arrHttp["archivo"])) {
//    echo   " Al terminar de clic sobre </font> <b>enviar</b> <font color=black> para almacenar los cambios</span>  <br>";
  }else{
  	echo "<br><font color=red>".$msgstr["pftwd1"]." <a href=javascript:Enviar()><strong>".$msgstr["send"]."</strong></a> ".$msgstr["pftwd2"]."</span>";
  }
?>

<input type=hidden name=Opcion>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=descripcion value="<?php echo $arrHttp["descripcion"]?>">
&nbsp;<textarea name=pftedit rows=30 cols=100% style="width:100%" nowrap>
<?php
	foreach ($fp as $linea){
  		echo str_replace('&','&amp;',$linea);
	}

?>
</textarea>

<?php
// READ HEADINGS (IF ANY)
reset($fp);
$file=str_replace($arrHttp["archivo"].".pft",$arrHttp["archivo"]."_h.txt",$file);
$head="";
$cols="";
if (file_exists($file)){	$fp=file($file);
	$cols="Y";
	foreach ($fp as $lin){		if (trim($lin)!="")	$head.=$lin;	}
}
if ($cols=="Y")
	echo $msgstr["r_heading"].":<br> <textarea name=headings rows=10 cols=30  nowrap>$head</textarea>";
echo "\n<script>
heading=\"".$cols."\"
</script>\n";
if (isset($arrHttp["desde"]) and ($arrHttp["desde"]=="dataentry" or $arrHttp["desde"]=="recibos")){
?>
<br>
<a href=javascript:ActualizarFormato()><h2><?php   echo $msgstr["update"]?></h2></a><?php}else{
?>
<br>
<a href=javascript:Enviar()><h2><?php   echo $msgstr["send"]?></h2></a>
<?php } ?>
</form>
<br>
Fields defined in the FDT <a href=fdt_leer.php?base=<?php echo $arrHttp["base"]?> target=_blank>Full window</a><br>
<iframe height=60% width=60%  scrolling=yes src=fdt_leer.php?base=<?php echo $arrHttp["base"]?>></iframe>
</body>
</html>