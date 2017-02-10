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
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=explode("_",$var);
		if (isset($variables[$tag[0]])){
			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}

}

include("../common/header.php");
include("javascript.php");
?>

<script>
function EnviarForma(){	document.forma1.submit()}
function Validar(){	err=""
	res=""
	if (Trim(document.forma1.tag1.value)==""){
		alert ("<?php echo $msgstr["missorder"]?>")
		document.forma1.tag1.focus()
		return "N"
	}
	status=""
	for (i=0;i<document.forma1.tag2.length;i++){		if (document.forma1.tag2[i].checked) status="ok"	}
	if (status=="" || Trim(document.forma1.tag3.value)==""){
		alert ("<?php echo $msgstr["missdate"]?>")
		document.forma1.tag2.focus()
		return "N"
	}
	if (Trim(document.forma1.tag5.value)=="" ){
		alert ("<?php echo $msgstr["err300a"]?>")
		document.forma1.tag5.focus()
		return "N"
	}

	if (Trim(document.forma1.tag16.value)=="" && Trim(document.forma1.tag17.value)==""){
		alert ("<?php echo $msgstr["err16"]?>")
		document.forma1.tag16.focus()
		return "N"
	}
	if (Trim(document.forma1.tag18.value)==""){
		alert ("<?php echo $msgstr["err18"]?>")
		document.forma1.tag18.focus()
		return "N"
	}
	if (Trim(document.forma1.tag50_0_b.value)=="") {		alert ("<?php echo $msgstr["err300b"]?>")
		document.forma1.tag50_0_b.focus()
		return "N"	}
	if (Trim(document.forma1.tag50_0_c.value)=="") {
		alert ("<?php echo $msgstr["err300c"]?>")
		document.forma1.tag50_0_c.focus()
		return "N"
	}
	ixBase=document.forma1.tag50_0_g.selectedIndex
	if (ixBase<1){
		alert ("<?php echo $msgstr["err3"]?>")
		document.forma1.tag50_0_g.focus()
		return "N"
	}
	ixBase=document.forma1.tag50_0_h.selectedIndex
	if (ixBase<1){
		alert ("<?php echo $msgstr["err5"]?>")
		document.forma1.tag50_0_h.focus()
		return "N"
	}
	if (document.forma1.tag50_0_g.selectedIndex==2){       // se verifica que esté presente el código del objeto si no se trata de un nuevo objeto
		if (Trim(document.forma1.tag50_0_i.value)==""){
			alert ("<?php echo $msgstr["err6"]?>")
			document.forma1.tag50_0_i.focus()
			return "N"
		}
	}
}
</script>
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
<?php                                                                                                                                      $encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php
		$m=explode('|',$arrHttp["mov"]);
		echo $m[1].": ".$msgstr["new"]?>
	</div>
	<div class="actions">
		<a href=order_new_menu.php class="defaultButton cancelButton">
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
echo "<font color=white>&nbsp; &nbsp; Script: order_new.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<form method=post name=forma1 action=order_new_update.php onSubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"].".par"?>>
<input type=hidden name=ValorCapturado value="">
<input type=hidden name=check_select value="">
<input type=hidden name=Indice value="">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn"]?>">
<input type=hidden name=valor value="">
<input type=hidden name=wks value=<?php echo $arrHttp["wks"]?>>
<?php
$fmt_test="S";
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


function VariablesDeAmbiente($var,$value){
global $arrHttp;

		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].=$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}

$m=explode('|',$arrHttp["mov"]);
$acqtype='^a'.$m[0].'^b'.$m[1];
echo "<script>\n";
echo "document.forma1.tag10.value='".$acqtype."'\n";
echo "</script>";

?>