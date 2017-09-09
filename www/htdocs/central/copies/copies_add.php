<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/acquisitions.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$db_addto=$arrHttp["base"];
$arrHttp["base"]="copies";
include("../common/header.php");
include("../acquisitions/javascript.php");

//READ THE FST OF THE BIBLIOGRAPHIC DATABASE IN ORDER TO GET THE TAG OF THE CONTROL FIELD
$tag_ctl="";
$error="";
LeerFst($db_addto);
if ($tag_ctl!=""){
	$Formato="v".$tag_ctl;

	//READ THE BIBLIOGRAPHIC RECORD TO GET THE CONTROL NUMBER

	$query = "&base=".$db_addto."&cipar=$db_path"."par/".$db_addto.".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=$Formato&Opcion=rango";
	$IsisScript=$xWxis."imprime.xis";
	include("../common/wxis_llamar.php");
	$valortag[1]=implode("",$contenido);
//print 'valortag1='.$valortag[1].'<p>';
	if ($valortag[1]=="")     //CHECK IF THE RECORD HAS CONTROL NUMBER
		$err_copies="Y";
	else
		$err_copies="N";

//READ THE FDT OF THE COPIES DATABASE TO SEE IF THE INVENTORY NUMBER IS AUTOINCREMENT
	LeerFdt("copies");
}

?>
<script language=javascript>
top.toolbarEnabled="N"
function Validar(){
	if (Trim(document.forma1.copies.value)=="" && Trim(document.forma1.tag10.value=="")){
		alert("<?php echo $msgstr["err_copies"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag1.value)==""){
		alert("<?php echo $msgstr["err_objectctl"]?>")
		return "N"
	}
	mydiv = document.getElementById("INE");	
	inv = document.forma1.tag30;
	if (inv.value=="") {
	mydiv.innerHTML='</br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $msgstr["errINE"];?></br></br>';
	mydiv.style.display='block';
	inv.focus();
	return "N";
	}
invdup=0;
invnumbers=document.getElementById("INVA").value;
/*alert(invnumbers);*/
if (invnumbers!="~"){
mydiv.innerHTML='</br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $msgstr["errEXCopyS"];?></br></br></br>';
mydiv.style.display='block';
inv.focus();
return "N";
}	
	check=-1;
	for(i=0;i<document.forma1.tag200.length;i++){	
    if(document.forma1.tag200[i].checked) check=i;}	
	if (check==-1) {	
	mydiv.innerHTML='</br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $msgstr["errSE"];?></br></br>';
	mydiv.style.display='block';	
	return "N";
	}
}

function RefrescarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.refrescarpicklist.picklist.value=tabla
	document.refrescarpicklist.Ctrl.value=Ctrl
	document.refrescarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=20,height=10,scrollbars, resizable")
	document.refrescarpicklist.submit()
	msgwin.focus()
}

function AgregarPicklist(tabla,Ctrl,valor){
	ValorOpcion=valor
	document.agregarpicklist.picklist.value=tabla
	document.agregarpicklist.Ctrl.value=Ctrl
	document.agregarpicklist.valor.value=valor
	msgwin=window.open("","Picklist","width=600,height=500,scrollbars, resizable")
	document.agregarpicklist.submit()
	msgwin.focus()
}

//SE ACTUALIZA EL SELECT CON LA TABLA ACTUALIADA
ValorTabla=""
SelectName=""
ValorOpcion=""
function AsignarTabla(){
	opciones=ValorTabla.split('$$$$')
	var Sel = document.getElementById(SelectName);
	Sel.options.length = 0;
	var newOpt =Sel.appendChild(document.createElement('option'));
    newOpt.text = "";
    newOpt.value = " ";
	for (x in opciones){
		op=opciones[x].split('|')
		if (op[0]=="")
			op[0]=op[1]
		if (op[1]=="")
			op[1]=op[0]
		var newOpt =Sel.appendChild(document.createElement('option'));
    	newOpt.text = op[1];
    	newOpt.value = op[0];
    	if (op[0]==ValorOpcion)
    		newOpt.selected=true
	}
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"]) and $arrHttp["encabezado"]=="s"){
	include("../common/institutional_info.php");
}
$urlcopies="";
if (isset($arrHttp["db_copies"])) $urlcopies="&db_copies=Y";
 echo "
	<div class=\"sectionInfo\">
		<div class=\"breadcrumb\">".
			 $msgstr["m_addcopies"]."
		</div>
		<div class=\"actions\">\n";
if ($err_copies!="Y" and $error==""){
	if (isset($arrHttp["encabezado"])){
				echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">
						<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
						<span><strong>". $msgstr["cancel"]."</strong></span>
					</a>";
	}
	?>
			<a href=../dataentry/fmt.php?base=<?php echo $db_addto."&cipar=$db_addto.par&Opcion=ver&ver=S&Mfn=".$arrHttp["Mfn"];
			if (isset($arrHttp["Formato"])) echo "&Formato=".$arrHttp["Formato"];
			echo $urlcopies?> class="defaultButton cancelButton">
				<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
				<span><strong><?php echo $msgstr["cancelar"]?></strong></span>
			</a>
			<a href=javascript:EnviarForma() class="defaultButton saveButton">
				<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
				<span><strong><?php echo $msgstr["actualizar"]?></strong></span>
			</a>
	<?php
}else{
?>
	<a href='javascript:top.toolbarEnabled="";top.Menu("same")' class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" /><?php echo $msgstr["back"]?></a>
<?php
}
echo "	</div>
		<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/copies/copies_add.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/copies/copies_add.html target=_blank>".$msgstr["edhlp"]."</a>";
 echo "<font color=white>&nbsp; &nbsp; Script: copies/copies_add.php";
?>
</font>
	</div>

<form method=post name=forma1 action=copies_add_add.php onSubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"].".par"?>>
<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=valor value="">

<div class="middle form">
<div name="INE" id="INE" style="color:#990000; display:none; font-style:italic; font-weight:bold;"></div>
<input type=hidden name=INVA id=INVA value="<?php echo $arrHttp["Mfn"]?>~">
<?php
if ($error!=""){
	echo "<script>top.toolbarEnabled=\"\"</script>\n";
	echo "<dd><h4>".$msgstr[$error]."</h4>";
	die;
}
if ($err_copies=="Y"){
	echo "<script>top.toolbarEnabled=\"\"</script>\n";
	echo "<dd><h4>".$msgstr["err_cannotaddcopies"]."</h4>";
	die;
}
echo "\n<div class=\"searchBox\">\n";
if ($AI=="Y"){
	echo "<label for=\"addCopies\">
		<strong>". $msgstr["numcopies"]."</strong>
		</label>
		<input type=\"text\" size=11 maxlength=2 name=\"copies\" id=\"copies\" value=\"\"/>
		&nbsp; &nbsp; &nbsp;";
}
echo "<a href=javascript:Show('copies','CN_".$db_addto."_".$valortag[1]."')>". $msgstr["dispcopies"]."</a>
<!--		<input type=checkbox value=Y checked name=createloans>
		<label for=\"regCopies\">
			<strong>".$msgstr["regcopies"]."</strong>
		</label>  --> ";
echo "</div>
	<div class=\"formContent\">";

$arrHttp["cipar"]="copies.par";
$fmt_test="S";
$arrHttp["wks"]="new.fmt";
$wks_avail["new"]=1;
$valortag[10]=$db_addto;
$arrHttp["db_addto"]=$db_addto;
include("../dataentry/plantilladeingreso.php");
ConstruyeWorksheetFmt();
include("../dataentry/dibujarhojaentrada.php");
PrepararFormato();

?>
</form>
	</div>
</div>
<?php include("../common/footer.php"); ?>
</body>
</html>
<form name=agregarpicklist action=../dbadmin/picklist_edit.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>

<form name=refrescarpicklist action=../dbadmin/picklist_refresh.php method=post target=Picklist>
   <input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
   <input type=hidden name=picklist>
   <input type=hidden name=Ctrl>
   <input type=hidden name=valor>
   <input type=hidden name=desde value=dataentry>
</form>

<?php
// ==================================================================================

function LeerFst($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr,$error;
// GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
	$archivo=$db_path.$base."/data/".$base.".fst";
	if (!file_exists($archivo)){
		echo "missing file ".$base."/data/".$base.".fst";
		die;
	}
	$fp=file($archivo);
	$tag_ctl="";
	$pref_ctl="CN_";
	foreach ($fp as $linea){
		$linea=trim($linea);
		$ix=strpos($linea,"\"CN_\"");
		if ($ix===false){
			$ix=strpos($linea,'|CN_|');
		}
		if ($ix===false){
		}else{
			$ix=strpos($linea," ");
			$tag_ctl=trim(substr($linea,0,$ix));
			break;
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl==""){
		$error="missingctl";
	}
}


function LeerFdt($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr;
// GET THE FDT TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
// GET THE INVENTORY NUMBER OF THE COPIES DATABASE TO SEE IF IS AUTOINCREMENT
	$archivo=$db_path.$base."/def/".$_SESSION["lang"]."/".$base.".fdt";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$archivo=$db_path.$base."/def/".$lang_db."/".$base.".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$base."/".$base.".fdt";
		    die;
		 }
	}
	$tag_ctl="";
	$pref_ctl="";
	$AI="";
	foreach ($fp as $linea){       //SEE IF THE INVENTORY NUMBER OF THE COPIES DATABASE IS AUTOINCREMENT
		$l=explode('|',$linea);
		if ($l[1]=="30"){
		   	if ($l[0]=="AI" || $l[7]=="AI") $AI="Y";
		}

	}
}
?>
<script language=javascript>
document.forma1.tag200[2].disabled = true;
function CheckInventory()
{
CheckInventoryDup(document.getElementById("tag30").value,1);
}
</script>
