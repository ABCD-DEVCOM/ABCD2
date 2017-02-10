<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../common/get_post.php");
include ("../config.php");


include ("../lang/dbadmin.php");
include ("../lang/admin.php");
$lang=$_SESSION["lang"];
switch ($arrHttp["format"]){
	case "recval":
		$ext=".val";
		break;
	case "beginf":
		$ext=".beg";
		break;
	case "endf"  :
		$ext=".end";
		break;
}

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

?>
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript>
//THIS VARIABLE IS FOR TESTING THE VALIDATION PFT
var pos_val=0

function PrepareString(){
	format='<?php echo $arrHttp["format"]?>'	ix=document.recval.tag.length
	ValorCapturado=""
	check=""
	for (i=0; i<ix; i++){		ixsel=document.recval.tag[i].selectedIndex
		pft=Trim(document.recval.format[i].value)
		if (pft!=""){
			if (format=="recval")
				check=document.recval.check[i].checked
			else
				check=""
			if (ixsel<1 && format!="recval"){				alert("<?php echo $msgstr["selfields"]?>")
				return false			}
			tag=Trim(document.recval.tag[i].options[ixsel].value)
			while (tag.length<4){				tag="0"+tag			}			ValorCapturado+=tag+escape(pft)+"$$|$$"+check+"\n"		}	}

	return ValorCapturado
}
function Enviar(){	ValorCapturado=PrepareString()
	//if (ValorCapturado==false) return
	document.recval.ValorCapturado.value=ValorCapturado
	document.recval.target=""
	document.recval.action="recval_save.php"
	document.recval.submit()

}

function SaveAs(){	if (document.recval.tipom.selectedIndex<1){		alert("You must select the type of record of the validation format to be saved")
		return	}
	ValorCapturado=PrepareString()
	if (ValorCapturado==false) return
	document.recval.ValorCapturado.value=ValorCapturado
	ix=document.recval.tipom.selectedIndex

	pref=document.recval.tipom.options[ix].value
	file=pref+"<?php echo $arrHttp["base"]."$ext"?>"
	document.recval.fn.value=file
	document.recval.target=""
	document.recval.action="recval_save.php"
	document.recval.submit()
}

function TestIndividual(){
	Mfn=msgwin.document.editar.Mfn.value
	if (Mfn==0)
		Mfn=document.recval.Mfn.value
	if (Mfn==0){
		alert("<?php echo $msgstr["mismfn"]?>")
		msgwin.focus()
		return
	}

	Formato=msgwin.document.editar.campo.value
	ixsel=document.recval.tag[pos_val].selectedIndex
	tag=Trim(document.recval.tag[pos_val].options[ixsel].value)
	while (tag.length<4){
		tag="0"+tag
	}
	Formato=tag+escape(Formato)+"$$|$$false\n"
	document.test.ValorCapturado.value=Formato
	msgwintest=window.open("","RecvalTest","width=740, height=400, status,scrollbars")
	msgwintest.document.close()
	document.test.Mfn.value=Mfn
	document.test.target="RecvalTest"
	document.test.ValorCapturado.value=Formato
	document.test.action="recval_test.php"
	document.test.submit()
	msgwintest.focus()
}

function TraerFormato(Tag){	document.recval.format[Tag].value=msgwin.document.editar.campo.value
	msgwin.close()}

function EditarFormato(ix){
    ixopc=document.recval.tag[ix].selectedIndex
    pos_val=ix
    Titulo=document.recval.tag[ix].options[ixopc].text
    pft=document.recval.format[ix].value
	msgwin=window.open("","edit","resizable=yes,width=700,height=500,top=0, left=0,scrollbars=yes,status=yes")
	msgwin.document.close()
	msgwin.document.writeln("<html><title>"+Titulo+"</title><body>")
	msgwin.document.writeln("<font style='font-size:10px;font-family:arial'><h5>"+Titulo+"</h5>")
	msgwin.document.writeln("<form name=editar><textarea rows=20 cols=80 name=campo>")
	msgwin.document.writeln("</textarea>")
	msgwin.document.editar.campo.value=pft
	msgwin.document.writeln("<?php echo $msgstr["testmfn"]?>: <input type=text size=5 name=Mfn><a href='javascript:window.opener.TestIndividual()'><?php echo $msgstr["test"]?></a>  &nbsp; &nbsp;")
	msgwin.document.writeln("<?php echo $msgstr["pftwd1"]?>")
	msgwin.document.writeln("<a href=javascript:window.opener.TraerFormato("+ix+")><?php echo $msgstr["send"]?></a>")
	msgwin.document.writeln("<?php echo $msgstr["pftwd2"]?>")
	msgwin.document.writeln("<p><a href=javascript:window.close()><?php echo $msgstr["close"]?></a>")
	msgwin.document.writeln("</form>")
	msgwin.focus()
}

function Test(Tag){
	Formato=PrepareString()
	if (Trim(document.recval.Mfn.value)==""){
		alert("<?php echo $msgstr["mismfn"]?>")
		return
	}
	msgwin=window.open("","RecvalTest","width=740, height=400, status,scrollbars")
	msgwin.document.close()
	document.test.Mfn.value=document.recval.Mfn.value
	document.test.target="RecvalTest"
	document.test.ValorCapturado.value=Formato
	document.test.action="recval_test.php"
	document.test.submit()
	msgwin.focus()

}

// ADD NEW VALIDATION FORMATS
function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getElement(psID) {
	if(!document.all) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

function DrawElement(selind,pft,ixpt,fatal){	selected=""
	selind=selind-1
	xhtml="<tr><td bgcolor=white><select name=tag>\n<option></option>"
	for (var opt in option){		o=option[opt].split('|')

		if (selind==opt) {			selected=" selected"
	    }
		xhtml+="<option value=\""+o[0]+"\""+selected+">"+o[1]+" ("+o[0]+" "+o[2]+")</option>\n";
		selected=""
	}
	xhtml+="</select><br><a href=javascript:AddElement("+ixpt+")><?php echo $msgstr["add"]?></a></td>"
	xhtml+="<td bgcolor=white><textarea name=format cols=80 rows=1>"+pft+"</textarea></td>"
	xhtml+="<td bgcolor=white><a href=\"javascript:EditarFormato("+ixpt+")\"><img src=../images/edit.png border=0></a>&nbsp; &nbsp;"
	xhtml+="&nbsp;<a href=javascript:DeleteElement("+ixpt+")><img src=../dataentry/img/toolbarDelete.png alt=\"<?php echo $msgstr["delete"]?>\" text=\"<?php $msgstr["delete"]?>\"></a>"
	<?php if ($arrHttp["format"]=="recval")
		echo 'xhtml+="<div><input type=checkbox name=check";
			if (fatal==true) xhtml+=" checked"
			xhtml+=">'.$msgstr["fatal"].'</div></td>"
			';
	?>
    return xhtml
}
function DeleteElement(ix){
	seccion=returnObjById( "rows" )
	html_sec="<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1>"
	html_sec+="<tr><td><?php echo $msgstr["campo"]?></td><td nowrap><?php echo $msgstr[$arrHttp["format"]]?></td><td></td>"
	Ctrl=eval("document.recval.tag")
	ixLength=Ctrl.length
	if (ixLength<3){
		document.recval.tag[ix].selectedIndex=0
		document.recval.format[ix].value=""
		document.recval.check[ix].checked=fa;se
	}else{
		ixE=-1
		tags=new Array()
		cont=new Array()
		for (i=0;i<ixLength;i++){
			if (i!=ix){
				Ctrl_ixsel=document.recval.tag[i].selectedIndex
				Ctrl_pft=document.recval.format[i].value
				Ctrl_checked=""
				<?php if ($arrHttp["format"]=="recval") echo "Ctrl_checked=document.recval.check[i].checked\n"?>
				ixE++
				html=DrawElement(Ctrl_ixsel,Ctrl_pft,ixE,Ctrl_checked)
    			html_sec+=html
			}
		}
		html_sec+="<tr><td>&nbsp;</td><td nowrap>&nbsp;</td><td>&nbsp;</td>"
		seccion.innerHTML = html_sec+"</table>"
	}

}



function AddElement(ixpos){
	seccion=returnObjById( "rows" )
	html="<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1>"
	html+="<tr><td><?php echo $msgstr["campo"]?></td><td nowrap><?php echo $msgstr[$arrHttp["format"]]?></td><td></td>"
	Ctrl=eval("document.recval.tag")
	if (Ctrl){
		if (Ctrl.length){
			ixLength=Ctrl.length
	        if (!ixLength) ixLength=1
	        ixnum=-1
			if (ixLength>0){
			    for (ia=0;ia<ixLength;ia++){
			    	ixnum++
			    	ixSel=document.recval.tag[ia].selectedIndex
			    	check=""
					<?php if ($arrHttp["format"]=="recval") echo "check=document.recval.check[ia].checked\n"?>
			    	pft=document.recval.format[ia].value
			    	xhtm=DrawElement(ixSel,pft,ixnum,check)
			    	html+=xhtm
			    	if (ia==ixpos){			    		ixnum++			    		nuevo=DrawElement(0,"",ixnum,"")
			    		html+=nuevo			    	}

			    }
		    }
		 }
	 }else{
		ia=0
	 }
    html+="<tr><td>&nbsp;</td><td nowrap>&nbsp;</td><td>&nbsp;</td>"
	seccion.innerHTML = html+"</table>"
}

</script>
</head>
<body>
<?php
if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
}else{	$encabezado="";}
if (isset($arrHttp["wks"])){
	$arrHttp["wks"]=urldecode($arrHttp["wks"]);
	$w=explode('|',$arrHttp["wks"]);
}else{	$w[0]=$arrHttp["base"].".fdt";
	$w[3]="";}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".
	$msgstr[$arrHttp['format']].": ".$arrHttp["base"]." (".$w[0]." ".$w[3].")
	</div>
	<div class=\"actions\">\n";
echo "<a href=\"typeofrecs.php?Opcion=update&type=&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["cancel"]."</strong></span>
	</a>
	</div>
	<div class=\"spacer\">&#160;</div>
	</div>";

?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/recval.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/recval.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: recval.php";
?>
</font>
</div>
 <div class="middle form">
	<div class="formContent">


<form name=recval  method=post onsubmit="javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php
if (isset($arrHttp["encabezado"]))
   echo "<input type=hidden name=encabezado value=s>";


//NAME OF THE FILE
$pref="";
if (isset($arrHttp["wks"])and $arrHttp["wks"]!="" ){	$w=explode('|',$arrHttp["wks"]);
	$pref=strtolower($w[1]);
	$field=$w[0];
	if (isset($w[2]) and $w[2]!=""){		$pref.="_".$w[2];	}
	$pref.="_";
	$field=$pref.$arrHttp["base"];}else{	$field=$arrHttp["base"];}
unset($pft);

//READ THE DATAENTRY FORMAT OF THE SELECTED TYPE OF RECORD. IF NOT FOUND, READ THE DATABASE FDT
$Dir=$db_path.$arrHttp["base"]."/def/";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$field.".fmt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$field.".fmt";
// IF THE FMT IS NOT FOUND THEN READ THE FDT
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
foreach ($fp as $value){	$value=trim($value);
	$t=explode('|',$value);
	if ($t[0]!='G'){
		$tag=$t[1];
		if ($tag!=""){
			$select[]=trim($value);
		}
	}
}
echo "\n<script>option=new Array()\n";
$ixo=-1;
foreach ($select as $value){
	$ixo=$ixo+1;
	$t=explode('|',$value);
	echo "option[$ixo]='".$t[1].'|'.$t[2].'|'.$t[5]."'\n";
}
echo "</script>\n";

$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$pref".$arrHttp["base"].$ext;
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/$pref".$arrHttp["base"].$ext;
if (file_exists($archivo)){
	$fp=file($archivo);
	$str_file=implode('%%%%',$fp);
	$fp=explode('###',$str_file);
	foreach ($fp as $value){
		if (trim($value)!=""){
			$pft[]=$value;		}
	}

}
echo "<center>";
echo "<div id=rows>\n";
echo "<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1>";
echo "<tr><td>".$msgstr["campo"]."</td><td nowrap>".$msgstr[$arrHttp["format"]]."</td><td></td>";
$ix=-1;
if (!isset($pft))
	$start=1;
else
	$start=count($pft);
for ($i=$start;$i<3;$i++)  $pft[]=":";
if (isset($pft)){
	foreach ($pft as $value){		$value=trim($value);
		if ($value=="") continue;
		$value=str_replace('%%%%',"",$value);
		$x=explode(':',$value,2);

		$tag=trim($x[0]);
//		if ($tag!=""){			$ix=$ix+1;
			echo "<tr><td bgcolor=white>";
			echo '<select name=tag><option></option>';
			foreach ($select as $val){				$t=explode('|',$val);
				if ($x[0]==$t[1])
					$selected=" selected";
				else
					$selected="";
				echo "<option value=".$t[1]." $selected>".$t[2]." (".$t[1]. " ".$t[5].")</option>\n";			}
			echo "</select><br><a href=javascript:AddElement($ix)>".$msgstr["add"]."</a></td>";
            $y=explode('$$|$$',$x[1]);
			echo "<td bgcolor=white><textarea cols=80 rows=1 name=format>";
			echo $y[0];
			echo "</textarea></td><td bgcolor=white><a href=\"javascript:EditarFormato($ix)\"><img src=../images/edit.png border=0></a>&nbsp; &nbsp;
			&nbsp;<a href=javascript:DeleteElement(".$ix.")><img src=../dataentry/img/toolbarDelete.png alt=\"".$msgstr["delete"]."\" text=\"".$msgstr["delete"]."\"></a>";
			if ($arrHttp["format"]=="recval"){				echo "<div><input type=checkbox name=check";
				if (isset($y[1]) and trim($y[1])=="true") echo " checked";
				echo ">".$msgstr["fatal"]."</div>";
				echo "</td>";
			}
		}
//	}
}

echo "<tr><td>&nbsp;</td><td nowrap>&nbsp;</td><td>&nbsp;</td>";
echo "</table></div>";

echo "\n<table>\n";
echo "<tr><td bgcolor=white>";
echo $msgstr["testmfn"];
echo "&nbsp; <input type=text size=5 name=Mfn> <a href=javascript:Test()>".$msgstr["test"]."</a>  &nbsp; &nbsp;";
echo "</td><td colspan=3  bgcolor=white><img src=../dataentry/img/toolbarSave.png> &nbsp;";

echo "<a href=javascript:Enviar()>".$msgstr["save"]."&nbsp;</a> ($pref".$arrHttp["base"]."$ext)  &nbsp; &nbsp ";
echo "<input type=hidden name=fn value=$pref".$arrHttp["base"]."$ext>";

$tr=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($tr))  $tr=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
if (file_exists($tr)){	echo "| &nbsp; &nbsp <img src=../dataentry/img/toolbarSave.png> &nbsp;";	echo $msgstr["saveas"].": ";

	$fp=file($tr);
    echo "<select name=tipom>\n<option></option>";
	$ix=0;
	$tr="";
	$nr="";
	foreach($fp as $value){
		$value=trim($value);
		if ($value!=""){
			if ($ix==0){
				$ttm=explode(" ",$value);
				$tl=trim($ttm[0]);
				if (isset($ttm[1])) $nr=trim($ttm[1]);
				$ix=1;
			}else{
				$ttm=explode('|',$value);
				$pref=$ttm[1];
				if (isset($ttm[1])) $pref.="_".$ttm[2];
				$pref.="_";
				$pref=strtolower($pref);
				echo "<option value=$pref>".$ttm[3]."</option>\n";
			}
		}
	}
	echo "</select>\n";
	echo "<a href=javascript:SaveAs()>".$msgstr["save"]."</a>  &nbsp; &nbsp";
}
if (isset($arrHttp["encabezado"])) echo "&nbsp; &nbsp; | &nbsp; &nbsp; <a href=typeofrecs.php?Opcion=update&base=".$arrHttp["base"]."$encabezado>".$msgstr["cancelar"]."</a>";
echo "</td></table>";
echo "<input type=hidden name=ValorCapturado>";
echo "</form>"
?>
<form name=test  method=post action=recval_test.php target=RecvalTest>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=Mfn>
<input type=hidden name=ValorCapturado>
</form>
</div></div>
<?php include("../common/footer.php");?>
</body></html>
