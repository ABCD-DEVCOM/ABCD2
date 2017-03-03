<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";

include("../lang/dbadmin.php");
$lang=$_SESSION["lang"];
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>
<script  src="../dataentry/js/lr_trim.js"></script>

<script languaje=javascript>

function EnviarTipoR(){	if (Trim(document.tipordef.tipom.value)==""){		alert("<?php echo $msgstr["typeofrecords_new"]?>")
		return	}
	document.tipordef.submit()}

function Enviar(rows){
	err=false	for (i=1;i<rows;i++){		c1=""
		c2=""
		c3=""
		c4=""
		tr=0
		for (j=1;j<5;j++){			Ctrl=eval("document.tor.cell"+i+"_"+j)
			switch (j){				case 1:
					c1=Ctrl.value
					break
				case 2:
					c2=Trim(Ctrl.value)
					if (c2=="")
					break
				case 3:
					c3=Trim(Ctrl.value )
					if (c3=="")
					break
				case 4:
					c4=Ctrl.value
					break			}
		}
		if (c1+c2+c3+c4==""){		}else{			if (c1=="" || (c2=="" && c3=="") || c4==""){				alert ("<?php echo $msgstr["typeofrecerror"]?>")
				err=true			}else{
				if (c2==""){					Ctrl=eval("document.tor.cell"+i+"_"+2)
					Ctrl.value="_"				}
				if (c3==""){
					Ctrl=eval("document.tor.cell"+i+"_"+3)
					Ctrl3=Ctrl
					Ctrl.value="_"
				}				tr++			}		}
	}

    if (err==false) document.tor.submit();}


</script>
<body>
<?php if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
}else{	$encabezado="";}
echo "
	<div class=\"sectionInfo\">
		<div class=\"breadcrumb\">".
				$msgstr["typeofrecords"].": ".$arrHttp["base"]."
		</div>
		<div class=\"actions\">\n";
		echo "<a href=menu_modificardb.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton cancelButton\">
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
			<span><strong>". $msgstr["cancel"]."</strong></span>
			</a>
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/typeofrecs.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/typeofrecs.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: typeofrecs_edit.php";
?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">


<br><center>
<?php
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks";
if (!file_exists($archivo))	$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks";
if (!file_exists($archivo)){
	echo "<p><span class=title>".$msgstr["typeofrecnowks"];
	if (!isset($arrHttp["encabezado"]))
		echo "<p><a href=menu_modificardb.php?base=".$arrHttp["base"].">".$msgstr["back"]."</a><p>";
	die;}

$fp = file($archivo);
foreach ($fp as $linea){	$fmt[]=$linea;}
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($archivo))    $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
if (!file_exists($archivo)){
	echo "<p>
	<form name=tipordef method=post action=typeofrecs_update.php onsubmit='javascript:return false'>
	<input type=hidden name=Opcion value=tipom>
	<input type=hidden name=base value=".$arrHttp["base"].">";
	if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
    echo "
<table border=0 background=../img/fondo0.jpg width=450>
	<tr>
		<TD valign=top colspan=2>" . $msgstr["typeofrecords_new"]."</td>
	</tr>
	<tr>
		<td width=80>".$msgstr["tag"]." 1</td><td width=400><input type=text name=tipom value='' size=4></td>
	</tr>
	<tr>
		<td width=80>".$msgstr["tag"]." 2</td><td><input type=text name=nivelr value='' size=4></td>
	</tr>

</table><p>
	<input type=submit value=' &nbsp; &nbsp; ".$msgstr["send"]." &nbsp; &nbsp; ' onClick=javascript:EnviarTipoR()>
</form>\n";
echo "</div></div></center>";
include("../common/footer.php");
echo "</body></html>";
	die;
}
echo "<form name=tor method=post action=typeofrecs_update.php onsubmit='return false'>
<input type=hidden name=base value=".$arrHttp["base"].">\n";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($archivo))
    $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
$fp = file($archivo);
$ix=0;

$j=0;
if ($fp) {
	foreach($fp as $linea){
		if (trim($linea)!="") {
			$linea=trim($linea);
			if ($ix==0){
				$ixpos=strpos($linea," ");
				if ($ixpos===false){					$tipom=trim($linea);
					$nivelr="";				}else{
					$tipom=trim(substr($linea,0,$ixpos));
					$nivelr=trim(substr($linea,$ixpos+1));
				}
				echo "
<table border=0 background=../img/fondo0.jpg width=450>
	<tr>
		<TD valign=top colspan=2>" .$msgstr["typeofrecords_new"]." ". $msgstr["typeofrecords_tags"]."</td>
	</tr>
	<tr>
		<td width=80>".$msgstr["tag"]." 1</td><td width=400><input type=text name=tipom value='$tipom' size=3></td>
	</tr>
	<tr>
		<td>".$msgstr["tag"]." 2</td><td><input type=text name=nivelr value='$nivelr' size=3></td>
	</tr>

</table><p>\n";
				$ix=1;
				echo "<table>";
				echo "<tr><td align=center>".$msgstr["fmt"]."</td><td align=center>".$msgstr["tag"]." 1 ".$msgstr["value"]."</td><td align=center>".$msgstr["tag"]." 2 ".$msgstr["value"]."</td><td align=center>".$msgstr["typeofrecords"]." ".$msgstr["description"]."</td><td>";
			}else{				$j=$j+1;
				$i=0;
				$l=explode('|',$linea);
				echo "<tr>";
				foreach ($l as $value) {					$value=trim($value);
					$i=$i+1;
					if ($i==1){						echo "<td><select name=cell$j"."_".$i.">
						<option value=\"\"></option>-- ";
						foreach ($fmt as $f){
							$xxtm=explode('|',$f);
							$xselected="";
							if ($xxtm[0].".fmt"==$l[0]) $xselected=" selected";							echo "<option value=\"".$xxtm[0].".fmt\"$xselected>".trim($xxtm[1])." (".$xxtm[0].")\n";						}
						echo "</td></select>";					}else{
						switch ($i){							case 2:
							case 3:
								$xsize=" size=10";
								break;
							case 4:
								$xsize=" size=30";
								break;						}						echo "<td><input type=text name=cell$j"."_".$i." value=\"$value\" $xsize></td>";
					}				}
			}
		}
	}

}

for ($k=$j+1;$k<$j+8;$k++){	$i=0;
	$linea="|||";
	$l=explode('|',$linea);
	echo "<tr>";
	foreach ($l as $value) {
		$i=$i+1;
		$value=trim($value);

		if ($i==1){
			echo "<td><select name=cell$k"."_".$i.">
			<option value=\"\"></option> ";
			foreach ($fmt as $f){
				$xxtm=explode('|',$f);
				echo "<option value=\"".$xxtm[0].".fmt\">".trim($xxtm[1])." (".$xxtm[0].")\n";
			}
			echo "</td></select>";
		}else{
			switch ($i){
				case 2:
				case 3:
					$xsize=" size=10";
					break;
				case 4:
					$xsize=" size=30";
					break;
			}
			echo "<td><input type=text name=cell$k"."_".$i." value=\"$value\" $xsize></td>";
		}

	}}
echo "</table>
<p>
<a href=javascript:Enviar($k)>".$msgstr["update"]."</a> &nbsp; &nbsp;";
if (!isset($arrHttp["encabezado"]))
 echo "<a href=menu_modificardb.php?base=".$arrHttp["base"].">".$msgstr["cancel"]."</a>";
?>
</form>
<p>
</center>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>
