<?
session_start();

$page="";
if (isset($_REQUEST['GET']))
	$page = $_REQUEST['GET'];
else
	if (isset($_REQUEST['POST'])) $page = $_REQUEST['POST'];

if (!(eregi("^[a-z_./]*$", $page) && !eregi("\\.\\.", $page))) {
	// Abort the script
	die("Invalid request");

}

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");

include("../lang/dbadmin.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt"))
	$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt");
else
	$fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt");
foreach($fp as $value) {	$f=explode('|',$value);
	if ($f[3]==1){		if (substr($f[13],0,1)!="@")
		    if (trim($f[13])!="")    // si no se especificó el formato para extraer la entrada principal se toma el tag del campo				$arrHttp["formato_e"]=$f[13]."'$$$'f(mfn,1,0)";
			else
				$arrHttp["formato_e"]="mhl,v".$f[1]."'$$$'f(mfn,1,0)";
		else
			$arrHttp["formato_e"]=$f[13];	}}
$arrHttp["formato_e"]=stripslashes($arrHttp["formato_e"]);


if (!isset($arrHttp["tagfst"])) $arrHttp["tagfst"]="";
if (!isset($arrHttp["delimitador"]))$arrHttp["delimitador"]="";
if (!isset($arrHttp["Tag"]))$arrHttp["Tag"]="";
if (!isset($arrHttp["prefijo"]))$arrHttp["prefijo"]="";
if (!isset($arrHttp["capturar"]))$arrHttp["capturar"]="";
if (!isset($arrHttp["capturar"]))$arrHttp["capturar"]="";
if (!isset($arrHttp["pref"]))$arrHttp["pref"]=$arrHttp["prefijo"];

$IsisScript=$xWxis."ifp.xis";
if (substr($arrHttp["formato_e"],0,1)=="@"){
	$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($arrHttp["formato_e"],1);
	if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".substr($arrHttp["formato_e"],1);
	$Formato="@".$Formato;
}else{
	$Formato=$arrHttp["formato_e"];
}
$query ="&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=autoridades"."&tagfst=".$arrHttp["tagfst"]."&prefijo=".urlencode($arrHttp["prefijo"])."&pref=".$arrHttp["pref"]."&formato_e=".urlencode($Formato);
include("../common/wxis_llamar.php");
$contenido = array_unique ($contenido);
include("../common/header.php");
echo "
		<script languaje=Javascript>
		document.onkeypress =
  			function (evt) {
    			var c = document.layers ? evt.which
            		: document.all ? event.keyCode
            		: evt.keyCode;
    			return true;
  		}
		var nav4 = window.Event ? true : false;

		function codes(e) {
  			if (nav4) // Navigator 4.0x
    			var whichCode = e.which

			else // Internet Explorer 4.0x
    			if (e.type == 'keypress') // the user entered a character
     				 var whichCode = e.keyCode
    			else
      				var whichCode = e.button;
  			if (e.type == 'keypress' && whichCode==13)
				IrA()
  			else
				if (whichCode==13) IrA()
		}
		\n";
	echo "Separa=\"".$arrHttp["delimitador"]."\"\n";
	echo "Tag=\"".$arrHttp["Tag"]."\"\n";
	echo "Prefijo=\"".$arrHttp["prefijo"]."\"\n";
	echo "cnv=\"N\"\n";
	echo "bsel=\"N\"\n";
	if (isset($arrHttp["cnvtab"]))
		echo "cnvtabsel=\"&cnvtabsel".$arrHttp["prefijo"]."\"\n";
	else
		echo "cnvtabsel=\"\"\n";
?>
	function CambiarBase(){
		tl=""
	   	nr=""
	  	i=document.Lista.baseSel.selectedIndex
	   	if (i==-1) i=0
	  	abd=document.Lista.baseSel.options[i].value
		if (i==-1 || i==0){			return
		}
		a=abd.split("|")
		basecap=a[0]
		ciparcap=basecap+".par"
		<?php $arrHttp["formato_e"]=str_replace('"','|',$arrHttp["formato_e"])?>
		formato_ix="<?php echo stripslashes($arrHttp["formato_e"])?>"
		Prefijo="&prefijo=<?php echo $arrHttp["prefijo"]?>"+"&formato_e="+ formato_ix
		if (top.frames.length>0){
			parent.indice.location.href="alfa.php?base="+basecap+"&cipar="+ciparcap+Prefijo+"&Opcion=autoridades&capturar=S"
		}else{
		  	parent.indice.location.href="alfa.php?base="+basecap+"&ciparcap="+cipar+Prefijo+"&Opcion=autoridades&capturar=S"

		}
	}
	function ObtenerTerminos(){//conversion table

		if (cnv=="S"){			if (document.Lista.cnvtab.selectedIndex>0){
        		cnvtabsel="&cnvtabsel="+document.Lista.cnvtab.options[document.Lista.cnvtab.selectedIndex].value
        	}else{
        		cnvtabsel=""
        	}
        }else{        	cnvtabsel=""        }
        basecap=""
        if (bsel=="S"){
        	if (document.Lista.baseSel.selectedIndex>0){
        		basecap=document.Lista.baseSel.options[document.Lista.baseSel.selectedIndex].value
        	}
        	top.basecap=basecap
        	top.ciparcap=basecap+".par"
        	top.cnvtabsel=cnvtabsel
        }else{        	basecap="<?php echo $arrHttp["base"]?>"        }
		Seleccion=""
		icuenta=0
		i=document.Lista.autoridades.selectedIndex
		for (i=0;i<document.Lista.autoridades.options.length; i++){
			if (document.Lista.autoridades.options[i].selected){
				icuenta=icuenta+1
				if (Seleccion=="")
					Seleccion=document.Lista.autoridades.options[i].value
				else
					Seleccion=Seleccion+Separa+document.Lista.autoridades.options[i].value
			}

		}
		db="<?php echo $arrHttp["base"]?>"

		if (Seleccion!=""){
			if (bsel=="S"){
            	if (top.NombreBaseCopiara=="")
            		db="<?php echo $arrHttp["base"]?>"
            	else
					db=top.NombreBaseCopiara
			}
			pref="<?php echo $arrHttp["pref"]?>"
    		cipar="<?php echo $arrHttp["cipar"]?>"
 <?php
 			if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]!=""){ 				echo "top.xeditar=\"S\"\n";

				echo 'parent.main.location="fmt.php?xx=xx&base="+db+"&cipar="+db+".par&basecap="+basecap+"&ciparcap="+basecap+".par&Mfn="+Seleccion+"&Opcion=captura_bd&ver=S&capturar=S"+cnvtabsel+"&Formato="+basecap'."\n";
			}else{				if (isset($arrHttp["Formato"]))
 					echo "Formato='&Formato=".$arrHttp["Formato"]."'\n";
 				else
 					echo "Formato=''\n";
				echo 'window.opener.top.main.location.href="fmt.php?cc=xx&base="+db+"&cipar="+cipar+"&Mfn="+Seleccion+"&Opcion=ver&ver=S&Formato="+Formato+cnvtabsel
				window.opener.focus()'."\n";
			}
?>
		}
	}

function Continuar(){
	i=document.Lista.autoridades.length-1
	a=document.Lista.autoridades[i].text
	AbrirIndice(a)
}

function IrA(ixj){
	a=document.Lista.ira.value
	AbrirIndice(a)
}

<?php
echo "</script>\n";
?>
	<body>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/alfa.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
	<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/alfa.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: alfa.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
				<form method=post name=Lista onSubmit="javascript:return false">
<?php
// si viene de la opción de capturar de otra base de datos se presenta la lista de bases de datos disponibles
if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
	$key_bd="";
	if (isset($arrHttp["base"])) $key_bd=$arrHttp["base"];
	$prefijo="";
	if (isset($arrHttp["prefijo"])) $prefijo=$arrHttp["prefijo"];
	if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]="";
	$fp = file($db_path."bases.dat");
	foreach ($fp as $linea){
		if (trim($linea)!="") {
			$ix=strpos($linea,"|");
			$llave=trim(substr($linea,0,$ix));
			if ($llave!="acces")
				$lista_bases[$llave]=$linea;
		}

	}
	echo "\n<script>bsel=\"S\"</script>\n";
	echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; ".$msgstr["database"].":
			<select name=baseSel onChange=CambiarBase() style=width:130px>
			<option value=\"\">
	\n";
	$i=-1;
	foreach ($lista_bases as $key => $value) {
	    $i++;
	    $v=explode('|',$value);
	    if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$key."_CENTRAL_ALL"])){
	    	if ($v[0]==$arrHttp["base"])
	    		$sel="selected";
	  		else
	  			$sel="";
			echo "<option value=\"".$key."\" $sel >".trim($v[1]);
		}
	}
	echo "\n</select> ";
	echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/ayuda_captura.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/ayuda_captura.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: alfa.php</font>";
// read conversion tables
	$archivo=$db_path."/cnv/z3950.cnv";
	if (file_exists($archivo)){		echo "\n<script>cnv=\"S\"</script>\n";
		echo "<br>".$msgstr["z3950_tab"].": ";
		echo "<select name=cnvtab>";
		echo "<option></option>";
		$fp=file($archivo);
		foreach ($fp as $value){
			$v=explode('|',$value);
			$xsel="";
			if (isset($arrHttp["cnvtabsel"])){				if ($v[0]==$arrHttp["cnvtabsel"]) $xsel=" selected";			}
			echo "<option value='".$v[0]."'$xsel>".$v[1]."\n";
		}
		echo "</select>";
	}else{
	}
}
if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S")
	$xwidth="380";
else
	$xwidth="570";
?>
	<table cellpadding=0 cellspacing=0 border=0  height=80%>


	<td  width=5% align=center><font size=1 face="verdana"><?php for ($i=65;$i<91;$i++ ) echo "<a href=javascript:AbrirIndice('".chr($i)."')>".chr($i)."</a><br>"?></td>
	<td width=95% valign=top>
	<Select name=autoridades multiple size=28 style="width:<?php echo $xwidth?>px; xheight=300px" onchange=ObtenerTerminos()>
<?php


?>
	</select></td>

	</table>
	</form>
	</div>
	</div>
	</body>
	</html>
