<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");



//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

function PresentarLeader($leader,$tc){
	$fp=file($leader);
	foreach ($fp as $value){
		$t=explode('|',$value);
		echo "<tr><td bgcolor=white>".$t[2]."</td>";
		echo "<td bgcolor=white>".$t[1]."</td>";
		$tag=$t[1];
		echo "<td bgcolor=white>";
		if (isset($tc[$tag][0]))
			echo $tc[$tag][0];

		echo "</td>";
		echo "<td bgcolor=white class=td>text</td>";
		echo "<td bgcolor=white class=td><input type=hidden name=subc></td>";
		echo "<td bgcolor=white class=td><input type=hidden name=editsubc></td>";
		echo "<td bgcolor=white class=td><input type=hidden name=occ></td>";
		echo "<td bgcolor=white class=td>";
		if (isset($tc[$tag][5])) echo $tc[$tag][5];
		echo "</td>";
	}
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_import"]." ".$msgstr["cnv_ver"]?>
	</div>
	<div class="actions">
<?php echo "<a href=javascript:self.close()  class=\"defaultButton cancelButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["cerrar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/carga_txt_ver.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/carga_txt_ver.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: carga_txt_ver.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";

$rep="";
$separador="";
$fp=file($db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"]);
foreach ($fp as $value){
	if ($rep==""){
		$separador=trim($value);
		$rep="S";
	}else{
		$a=explode('|',$value);
		$tc[$a[1]][0]=$a[0];
		$tc[$a[1]][1]=$a[1];
		$tc[$a[1]][2]=$a[2];
		$tc[$a[1]][3]=$a[3];
		$tc[$a[1]][4]=$a[4];
		$tc[$a[1]][5]=$a[5];
	}
}

echo "<p><font face=arial><b>".$msgstr["cnv_tab"].": </b>".$arrHttp["cnv"];
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
echo "<table border=0 bgcolor=#cccccc cellpadding=3 cellspacing=1 class=td>";
echo "<tr><td>".$msgstr["campo"]."</td><td>".$msgstr["tag"]."</td><td>".$msgstr["cnv_rotulo"]."</td><td>".$msgstr["tipo"]."</td><td>".$msgstr["subc"]."</td><td>".$msgstr["editsubc"]."</td><td>".$msgstr["osep"]."</td><td nowrap>".$msgstr["pftex"]."</td>";
$ix=-1;

foreach ($fp as $value){	$t=explode('|',$value);
	if ($t[0]!='G'){
		if ($t[0]=="LDR"){
			PresentarLeader($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/leader.fdt",$tc);
			continue;
		}
		$ix=$ix+1;
		$tag=$t[1];
		if (isset($tc[$tag][0])){
			echo "<tr><td bgcolor=white>".$t[2]."</td>";
			echo "<td bgcolor=white>$tag</td>";
			echo "<td bgcolor=white nowrap>". $tc[$tag][0]."</td>";
			echo "<td bgcolor=white nowrap>";
			$tipo=$t[7];
			switch ($tipo){
				case "O":
					echo "Option";
					break;
				case "C":
					echo "Check (Repetible)";
					break;
				case "A":
					echo "HTML";
					break;
				case "R":
					echo "Text (Repetible)";
					break;
				default:
					echo "Text";
					break;
			}

			echo "</td><td bgcolor=white>";
			echo $tc[$tag][2];
			echo "</td><td bgcolor=white>";
			echo $tc[$tag][3];
			echo "</td><td bgcolor=white>";
			echo $tc[$tag][4];
			echo "</td><td bgcolor=white nowrap>";
			echo $tc[$tag][5];
			echo "</td>\n";
		}
	}
}
echo "<tr><td colspan=8 bgcolor=linen>";
if ($separador!='[TABS]')
	 echo $msgstr["cnv_sep"].": $separador</td>";
else
	echo "<input type=checkbox checked>".$msgstr["delimited_tab"]."</td>";
$arch="";
if (isset($arrHttp["cnv"])){
	$ixpos=strpos($arrHttp["cnv"],".");
	$arch=substr($arrHttp["cnv"],0,$ixpos);
}
?>

</div>
</div>

</body>
</html>