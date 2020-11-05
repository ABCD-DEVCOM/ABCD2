<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global  $arrHttp;

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
// se lee el archivo mm.fdt
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (file_exists($archivo))
	$fpTm=file($archivo);
else
	$fpTm=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt");
foreach ($fpTm as $linea){
	if (trim($linea)!="") {		$Fdt[]=$linea;
	}
}
//sort($Fdt);
if (isset($arrHttp["fmt_name"])) {
	if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["fmt_name"].".fmt"))
    	$fp = file($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["fmt_name"].".fmt");
    else
		$fp = file($db_path.$base."/def/".$lang_db."/".$arrHttp["fmt_name"].".fmt");
	$arrHttp["tagsel"]="";
	foreach($fp as $linea){
		if (trim($linea)!=""){			$t=explode('|',$linea);			$tag_s[trim($t[1])]=trim($linea);
		}	}
}
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
include("../common/header.php");

?>

<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/selectbox.js></script>
<style type=text/css>
div#editformat{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
div#generateformat{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script languaje=javascript>

function AbrirVentana(Archivo){
	xDir="<?php echo 'ayudas/'?>"
	msgwin=window.open(xDir+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function Genera_Fmt(){  	formato=""
  	for (i=0;i<document.forma1.list21.options.length;i++){
	    campo=document.forma1.list21.options[i].value
	    if (document.forma1.link_fdt.checked){
	    	c=campo.split('|')
	    	tipo=campo[0]
	    	if (tipo=='H' || tipo=='L' || tipo=='S'){	    	}else{	    		c[18]=1
	    		campo=""
	    		for (j=0;j<c.length;j++){	    			campo+= c[j]
	    			if (j!=c.length-1)
	    				campo+="|"	    		}	    	}
	  	}
	    formato+=campo+"\n"
	}
    return formato}

function Preview(){	formato=Genera_Fmt()
	if (formato=="" ){
	  	alert("<?php echo $msgstr["selfieldsfmt"]?>")
	  	return
	}
	var width = screen.availWidth;
    var height = screen.availHeight
	msgwin=window.open("","test_fmt","width="+width+", height="+height+" resizable=yes, scrollbars=yes, menu=yes")
	msgwin.document.close()
    msgwin.focus()
	document.preview.fmt.value=escape(formato)
	document.preview.submit()
}

function GenerarFormato(){
	formato=Genera_Fmt()
	if (formato=="" ){
	  	alert("<?php echo $msgstr["selfieldsfmt"]?>")
	  	return
	}
	document.forma1.wks.value=formato
	if (Trim(document.forma1.nombre.value)==""){		alert("<?php echo $msgstr["misfilen"]?>")
		return	}
	if (Trim(document.forma1.descripcion.value)==""){
		alert("<?php echo $msgstr["misformatd"]?>")
		return
	}
	fn=document.forma1.nombre.value
	bool=  /^[a-z][\w]+$/i.test(fn)
 	if (bool){

   	}
   	else {
      	alert("<?php echo $msgstr["errfilename"]?>");
      	return
   	}
	document.forma1.submit()
}
function EditarFormato(){	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){		alert("<?php echo $msgstr["selpfted"]?>")
		return	}
	document.getElementById('loading').style.display='block';
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.forma1.fmt_name.value=fmt[0]
    document.forma1.fmt_desc.value=document.forma1.fmt.options[ix].text
    document.forma1.action="fdt.php"
    document.forma1.submit()}

function CopiarFormato(){
	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){
		alert("<?php echo $msgstr["selpfted"]?>")
		return
	}
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.forma1.fmt_name.value=fmt[0]
    document.forma1.fmt_desc.value=document.forma1.fmt.options[ix].text
    document.forma1.action="fmt_saveas.php"
    document.forma1.Opcion.value="saveas";
    document.forma1.submit()
}

function EliminarFormato(){
	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){
		alert("<?php echo $msgstr["selpftdel"]?>")
		return
	}
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.frmdelete.fmt.value=fmt[0]
    document.frmdelete.path.value="def"
    document.frmdelete.submit()
}

</script>
<body>
<div id="loading">
  <img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading..." />
</div>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
			<div class="breadcrumb">
				<?php echo $msgstr["credfmt"].": ".$arrHttp["base"]?>
			</div>

			<div class="actions">
<?php if ($arrHttp["Opcion"]=="new"){
				echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">";
	}else{
		       echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
	}
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["cancel"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<form name=forma1 method=post action=fmt_update.php onsubmit="Javascript:return false" >
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php if (isset($arrHttp["cipar"])) echo $arrHttp["cipar"]?>>
<input type=hidden name=tagsel>
<input type=hidden name=Opcion>
<input type=hidden name=wks>
<input type=hidden name=fmt_name>
<input type=hidden name=fmt_desc>
<input type=hidden name=ret_script value=fmt.php>
<?php if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>\n"?>
 <script type="text/javascript">


</script>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/fmt.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/fmt.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: fmt.php";
unset($fp);
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/"."formatos.wks";
?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center>

<table border=0 >
    <td valign=top>
    <?php echo $msgstr["selfmt"]?></td>
    <td><select name=fmt>
    <option value=""></option>
<?php

if (!file_exists($archivo)) $archivo = $db_path.$arrHttp["base"]."/def/".$lang_db."/"."formatos.wks";
if (file_exists($archivo)){	$fp=file($archivo);
	if (isset($fp)) {
		foreach($fp as $linea){
			//echo "***$linea<br>";
			if (trim($linea)!="") {
				$linea=trim($linea);
				$l=explode('|',$linea);
				$cod=trim($l[0]);
				$nom=trim($l[1]);
				$oper="|";
				if (isset($l[2])) $oper.=$l[2];
				echo "<option value='$cod$oper'>$nom</option>\n";
			}
		}

	}
}
?>
    </select> <a href=javascript:EditarFormato()><?php echo $msgstr["edit"]?></a> | <a href=javascript:EliminarFormato()><?php echo $msgstr["delete"]?></a> | <a href=javascript:CopiarFormato()><?php echo $msgstr["saveas"]?></a>
    </td>

</table>
<p>
<table border=1>
    <tr>
    <td valign=top colspan=4>
    	<div id=generateformat>
    	<table>
			<td valign=top colspan=4><?php echo $msgstr["selfields"]?></td><tr>
			<td colspan=4>
			<table><td>
				<Select name=list11 style="width:250px" multiple size=20 onDblClick="moveSelectedOptions(this.form['list11'],this.form['list21'],false)">

<?php  $t=array();
 	foreach ($Fdt as $linea){
 		$linea=trim($linea);
		$t=explode('|',$linea);
		if ($t[0]!="S"){			if ($t[0]=="H" or $t[0]=="L"){
				if (!isset($tag_s[$linea])){					$t[1]=$t[0];
		   			echo "<option value='".trim($linea)."'>".trim($t[2])." (".trim($t[1]).")\n";
				}			}else{
	   			$key=trim($t[1]);
	   			if (!isset($tag_s[$key])){
		   			echo "<option value='".trim($linea)."'>".trim($t[2])." (".trim($t[1]).")\n";
				}else{					$seleccionados[$key]=$linea;
				}			}
		}
  	}
?>
				</select>
			</td>
			<TD VALIGN=MIDDLE ALIGN=CENTER>
				<A HREF="#" onClick="moveSelectedOptions(document.forms[0]['list11'],document.forms[0]['list21'],false);return false;"><img src=../dataentry/img/barArrowRight.png border=0></A><BR><BR>
				<A HREF="#" onClick="moveAllOptions(document.forms[0]['list11'],document.forms[0]['list21'],false); return false;"><img src=../dataentry/img/barArrowRight.png border=0><img src=../dataentry/img/barArrowRight.png border=0></A><BR><BR>
				<A HREF="#" onClick="moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;"><img src=../dataentry/img/barArrowLeft.png border=0><img src=../dataentry/img/barArrowLeft.png border=0></A><BR><BR>
				<A HREF="#" onClick="moveSelectedOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;"><img src=../dataentry/img/barArrowLeft.png border=0></A>


			</TD>
			<TD>
				<SELECT NAME="list21" MULTIPLE SIZE=20 style="width:250px" onDblClick="moveSelectedOptions(this.form['list21'],this.form['list11'],false)">
<?php  $t=array();
 	foreach ($tag_s as $linea){

	   	$key=trim($linea);
	   	if (isset($seleccionados[$key])){	   		$t=explode('|',$seleccionados[$key]);
		   	echo "<option value='".trim($seleccionados[$key])."'>".$t[2]." (".trim($t[1]).")\n";
		}else{			$t=explode('|',$key);			if ($t[0]=="H" or $t[0]=="L") $t[1]=$t[0];
		   	echo "<option value='".$key."'>".$t[2]." (".trim($t[1]).")\n";		}
  	}
?>
				</SELECT>
			</TD>
			<TD ALIGN="CENTER" VALIGN="MIDDLE">
				<INPUT TYPE="button" VALUE="<?php echo $msgstr["up"]?>" onClick="moveOptionUp(this.form['list21'])">
				<BR><BR>
				<INPUT TYPE="button" VALUE="<?php echo $msgstr["down"]?>" onClick="moveOptionDown(this.form['list21'])">
				<br><br><a href=javascript:Preview()><img src=../dataentry/img/preview.gif border=0 alt="preview"></a>
				<br><br>
			</TD>
		</table>
	</td>
	<tr><td colspan=4><input type=checkbox name=link_fdt><?php echo $msgstr["link_fdt_msg"]?></td></tr>
	<tr><td colspan=4><?php echo $msgstr["whendone"]?></td></tr>
	<tr><td valign=top colspan=4 >
		<?php echo $msgstr["name"]?>: <input type=text name=nombre size=8 maxlength=12> <?php echo $msgstr["description"]?>: <input type=text size=50 maxlength=50 name=descripcion> &nbsp;
		<a href=javascript:GenerarFormato()><img src=../dataentry/img/barSave.png alt="save" border=0 align=absmiddle></a>
		</td>
</div>
</table>
<script>
<?php if ((isset($arrHttp["fmt_name"]))) {
       echo "document.forma1.nombre.value=\"".$arrHttp['fmt_name']."\"\n";
	   echo "document.forma1.descripcion.value=\"".$arrHttp['fmt_desc']."\"\n";
   }
?>
</script>
</table>
</form>
<form name=preview action=../dataentry/fmt_test.php target=test_fmt method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=fmt>
</form>

<form name=frmdelete action=fmt_delete.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=path>
<input type=hidden name=fmt>
<?php if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>\n"?>
</form>
<form name=assignto action=fmt_update.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=path>
<input type=hidden name=sel_oper>
<input type=hidden name=fmt>
<?php if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>\n"?>
</form>
</center>
</div>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>

