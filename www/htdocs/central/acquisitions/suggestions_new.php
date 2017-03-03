<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");

include("../common/get_post.php");
$arrHttp["Mfn"]="New";
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
include("javascript.php");
?>

<script>
function Validar(){	err=""
	res=""	for (i=0;i<document.forma1.tag2.length;i++){		if (document.forma1.tag2[i].checked) res="Y"	}
	if (res==""){		alert ("<?php echo $msgstr["err2"]?>")
		return "N"	}
	res=""
//SE VERIFICA SI ES UN OBJETO NUEVO O UNA COPIA
/*	for (i=0;i<document.forma1.tag3.length;i++){
		if (document.forma1.tag3[i].checked) res="Y"
	}
	if (res==""){
		alert ("<?php echo $msgstr["err3"]?>")
		return "N"
	}
	if (document.forma1.tag3[1].checked){       // se verifica que esté presente el código del objeto si no se trata de un nuevo objeto		if (Trim(document.forma1.tag6.value)==""){			alert ("<?php echo $msgstr["err6"]?>")
			return "N"		}	} */
	if (Trim(document.forma1.tag16.value)=="" && Trim(document.forma1.tag17.value)==""){
		alert ("<?php echo $msgstr["err16"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag18.value)==""){
		alert ("<?php echo $msgstr["err18"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag200.value)==""){
		alert ("<?php echo $msgstr["err200"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag210.value)==""){
		alert ("<?php echo $msgstr["err210"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag211.value)==""){
		alert ("<?php echo $msgstr["err211"]?>")
		return "N"
	}
	if (Trim(document.forma1.tag220.value)==""){
		alert ("<?php echo $msgstr["err220"]?>")
		return "N"
	}
	return "Y";}
</script>
<?php                                                                                                                                      $encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<style>
	#headerDiv, #contentDiv {
	float: right;
	width: 510px;
	}
	#titleText {
	float: right;
	font-size: 1.2em;
	font-weight: bold;
	margin: 5px 10px;
	}
	headerDiv {
	background-color: #ffffff;
	color: #000000;
	}
	contentDiv {
	background-color: #FFE694;
	}
	myContent {
	margin: 5px 10px;
	}
	headerDiv a {
	float: left;
	margin: 10px 10px 5px 5px;
	}
	headerDiv a:hover {
	color: #;
	}
</style>

<style type="text/css">
#wrapper {
	text-align:left;
	margin:0 auto;
	width:100%;
	xmin-height:10px;
	xborder:1px solid #ccc;
	padding:0px;
}


a {
	color:blue;
	cursor:pointer;
}


#myvar {
	border:1px solid #ccc;
	background:#ffffff;
	padding:2px;
}
</style>
<script>
function switchMenu(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != "none" ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}

	function toggle(showHideDiv, switchTextDiv) {
		var ele = document.getElementById(showHideDiv);
		var text = document.getElementById(switchTextDiv);
		if(ele.style.display == "block") {
	    	ele.style.display = "none";
	  	}
		else {
			ele.style.display = "block";
		}
	}
 </script>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["new"]?>
	</div>
	<div class="actions">

		<a href=overview.php?encabezado=s&base=<?php echo $arrHttp["base"]?> class="defaultButton cancelButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["cancel"]?></strong></span>
		</a>
		<a href=javascript:EnviarForma() class="defaultButton saveButton">
			<img src=../images/defaultButton_iconBorder.gif alt="" title="" />
			<span><strong><?php echo $msgstr["actualizar"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/suggestions_new.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/suggestions_new.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: suggestions_new.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<form method=post name=forma1 action=suggestions_new_update.php onSubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"].".par"?>>
<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=valor value="">
<?php
$fmt_test="S";
$arrHttp["wks"]="new.fmt";
include("../dataentry/plantilladeingreso.php");
ConstruyeWorksheetFmt();
include("../dataentry/dibujarhojaentrada.php");
PrepararFormato();
?>
 </form>
	</div>
</div>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>